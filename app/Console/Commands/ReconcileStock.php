<?php

namespace App\Console\Commands;

use App\Models\OrderItem;
use App\Models\ProductStock;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ReconcileStock extends Command
{
    protected $signature = 'stock:reconcile {--dry-run : Preview changes without applying}';
    protected $description = 'Reconcile product stock by deducting quantities from existing paid orders';

    public function handle(): int
    {
        $dryRun = $this->option('dry-run');

        if ($dryRun) {
            $this->warn('DRY RUN MODE — no changes will be made.');
        }

        // Sum ordered quantities per product for paid/non-cancelled orders
        $orderedQuantities = OrderItem::query()
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereIn('orders.payment_status', ['paid'])
            ->whereNotIn('orders.status', ['cancelled'])
            ->select('order_items.product_id', DB::raw('SUM(order_items.quantity) as total_ordered'))
            ->groupBy('order_items.product_id')
            ->get();

        if ($orderedQuantities->isEmpty()) {
            $this->info('No paid orders found. Nothing to reconcile.');
            return 0;
        }

        $this->info("Found {$orderedQuantities->count()} products with paid orders.");
        $this->newLine();

        $headers = ['Product ID', 'Product', 'Current Stock', 'Total Ordered', 'Corrected Stock', 'Action'];
        $rows = [];

        foreach ($orderedQuantities as $item) {
            $stocks = ProductStock::where('product_id', $item->product_id)->get();
            $currentTotal = $stocks->sum('quantity');
            $product = \App\Models\Product::find($item->product_id);
            $productName = $product ? $product->title : "ID #{$item->product_id}";

            // The stock should be: current - ordered (since orders weren't deducted)
            // But we need to check if stock was already partially deducted
            $correctedTotal = max(0, $currentTotal - $item->total_ordered);
            $action = $currentTotal > $correctedTotal ? 'DEDUCT ' . ($currentTotal - $correctedTotal) : 'NO CHANGE';

            $rows[] = [
                $item->product_id,
                substr($productName, 0, 30),
                $currentTotal,
                $item->total_ordered,
                $correctedTotal,
                $action,
            ];

            if (!$dryRun && $currentTotal > $correctedTotal) {
                $remaining = $item->total_ordered;
                foreach ($stocks as $stock) {
                    if ($remaining <= 0) break;
                    $deduct = min($remaining, $stock->quantity);
                    $stock->decrement('quantity', $deduct);
                    $remaining -= $deduct;
                }
            }
        }

        $this->table($headers, $rows);
        $this->newLine();

        if ($dryRun) {
            $this->warn('This was a dry run. Run without --dry-run to apply changes.');
        } else {
            $this->info('Stock reconciliation completed successfully.');
        }

        return 0;
    }
}
