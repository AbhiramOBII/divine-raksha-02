<?php

namespace App\Console\Commands;

use App\Mail\OrderConfirmation;
use App\Mail\OrderStatusUpdated;
use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTestEmail extends Command
{
    protected $signature = 'mail:test {--user=abhiram.chandramohan@gmail.com} {--admin=rakshadivine@gmail.com}';
    protected $description = 'Send test order confirmation and status update emails';

    public function handle()
    {
        $userEmail = $this->option('user');
        $adminEmail = $this->option('admin');

        // Get the latest order for test data
        $order = Order::with('items')->latest()->first();

        if (!$order) {
            $this->error('No orders found in the database to use as test data.');
            return 1;
        }

        $this->info("Using order #{$order->order_number} as test data");
        $this->newLine();

        // 1. Order Confirmation
        $this->info('Sending Order Confirmation...');
        try {
            Mail::to($userEmail)
                ->cc($adminEmail)
                ->send(new OrderConfirmation($order));
            $this->info("  -> Sent to user: {$userEmail}");
            $this->info("  -> CC to admin: {$adminEmail}");
        } catch (\Exception $e) {
            $this->error('  -> Failed: ' . $e->getMessage());
        }

        $this->newLine();

        // 2. Order Status Updated
        $this->info('Sending Order Status Update...');
        try {
            Mail::to($userEmail)
                ->cc($adminEmail)
                ->send(new OrderStatusUpdated($order, 'pending'));
            $this->info("  -> Sent to user: {$userEmail}");
            $this->info("  -> CC to admin: {$adminEmail}");
        } catch (\Exception $e) {
            $this->error('  -> Failed: ' . $e->getMessage());
        }

        $this->newLine();
        $this->info('Done! Check both inboxes.');

        return 0;
    }
}
