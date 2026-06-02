<?php

namespace App\Console\Commands;

use App\Mail\OrderConfirmation;
use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ResendOrderConfirmations extends Command
{
    protected $signature = 'orders:resend-confirmations
                            {--status=paid : Filter by payment status (paid, pending, all)}
                            {--order= : Send for a specific order number only}
                            {--dry-run : Preview which emails would be sent without actually sending}';

    protected $description = 'Resend order confirmation emails to all customers with existing orders';

    public function handle()
    {
        $status = $this->option('status');
        $orderNumber = $this->option('order');
        $dryRun = $this->option('dry-run');

        $query = Order::with('items')->latest();

        if ($orderNumber) {
            $query->where('order_number', $orderNumber);
        } elseif ($status !== 'all') {
            $query->where('payment_status', $status);
        }

        $orders = $query->get();

        if ($orders->isEmpty()) {
            $this->warn('No orders found matching the criteria.');
            return 1;
        }

        $this->info("Found {$orders->count()} order(s) to process.");

        if ($dryRun) {
            $this->warn('DRY RUN - No emails will be sent.');
            $this->newLine();
        }

        $this->table(
            ['#', 'Order', 'Customer', 'Email', 'Total', 'Status', 'Date'],
            $orders->map(fn ($o, $i) => [
                $i + 1,
                $o->order_number,
                $o->customer_name,
                $o->customer_email,
                '₹' . number_format($o->total),
                $o->payment_status,
                $o->created_at->format('d M Y'),
            ])
        );

        if (!$dryRun && !$this->confirm('Send confirmation emails to all listed customers?')) {
            $this->info('Cancelled.');
            return 0;
        }

        $sent = 0;
        $failed = 0;
        $bar = $this->output->createProgressBar($orders->count());
        $bar->start();

        foreach ($orders as $order) {
            if ($dryRun) {
                $bar->advance();
                $sent++;
                continue;
            }

            try {
                $adminEmail = setting('admin_order_email', 'rakshadivine@gmail.com');
                Mail::to($order->customer_email)
                    ->cc($adminEmail)
                    ->send(new OrderConfirmation($order));
                $sent++;
            } catch (\Exception $e) {
                $failed++;
                $this->newLine();
                $this->error("  Failed for {$order->order_number} ({$order->customer_email}): {$e->getMessage()}");
            }

            $bar->advance();

            // Small delay to avoid rate limiting
            usleep(500000); // 0.5 seconds
        }

        $bar->finish();
        $this->newLine(2);

        if ($dryRun) {
            $this->info("DRY RUN complete. {$sent} email(s) would be sent.");
        } else {
            $this->info("Done! Sent: {$sent} | Failed: {$failed}");
        }

        return 0;
    }
}
