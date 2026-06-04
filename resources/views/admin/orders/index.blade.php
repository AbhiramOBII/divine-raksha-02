@extends('admin.layouts.app')

@section('title', 'Orders')
@section('page-title', 'Orders')

@section('content')
    <!-- Stats Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-4 mb-6">
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <p class="text-xs text-gray-500 uppercase tracking-wide">Total</p>
            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 shadow-sm border border-yellow-100">
            <p class="text-xs text-yellow-600 uppercase tracking-wide">Pending</p>
            <p class="text-2xl font-bold text-yellow-700 mt-1">{{ $stats['pending'] }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-100">
            <p class="text-xs text-blue-600 uppercase tracking-wide">Processing</p>
            <p class="text-2xl font-bold text-blue-700 mt-1">{{ $stats['processing'] }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 shadow-sm border border-indigo-100">
            <p class="text-xs text-indigo-600 uppercase tracking-wide">Shipped</p>
            <p class="text-2xl font-bold text-indigo-700 mt-1">{{ $stats['shipped'] }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 shadow-sm border border-green-100">
            <p class="text-xs text-green-600 uppercase tracking-wide">Delivered</p>
            <p class="text-2xl font-bold text-green-700 mt-1">{{ $stats['delivered'] }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 shadow-sm border border-red-100">
            <p class="text-xs text-red-600 uppercase tracking-wide">Cancelled</p>
            <p class="text-2xl font-bold text-red-700 mt-1">{{ $stats['cancelled'] }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 shadow-sm border border-sacred-gold/30">
            <p class="text-xs text-sacred-gold uppercase tracking-wide">Revenue</p>
            <p class="text-xl font-bold text-gray-900 mt-1">₹{{ number_format($stats['revenue'], 0) }}</p>
        </div>
    </div>

    <!-- Product Report -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6" x-data="{ open: false }">
        <button @click="open = !open" class="w-full flex items-center justify-between px-6 py-4 text-left">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-royal-blue/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-royal-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 text-sm">Product Order Summary</h3>
                    <p class="text-xs text-gray-500">{{ now()->format('d M Y') }} — {{ $productSummary->count() }} products ordered</p>
                </div>
            </div>
            <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </button>

        <div x-show="open" x-cloak x-transition class="border-t border-gray-100 px-6 py-4">
            @if($productSummary->isNotEmpty())
                <div class="space-y-2 max-h-80 overflow-y-auto">
                    @foreach($productSummary as $item)
                        <div class="flex items-center justify-between py-2 px-3 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $item->product_name }}</p>
                                <p class="text-xs text-gray-500">{{ $item->order_count }} {{ Str::plural('order', $item->order_count) }} · {{ $item->total_qty }} {{ Str::plural('unit', $item->total_qty) }}</p>
                            </div>
                            <a href="{{ route('admin.orders.index', ['search' => $item->product_name]) }}"
                               class="ml-3 shrink-0 text-xs font-medium text-royal-blue hover:text-deep-royal px-3 py-1.5 bg-royal-blue/5 rounded-lg hover:bg-royal-blue/10 transition-colors">
                                View Orders →
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-500 text-center py-4">No product orders found.</p>
            @endif
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6" x-data="orderFilters()">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="space-y-4">
            <div class="flex flex-col sm:flex-row gap-4 flex-wrap">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search order #, name, email, phone..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                </div>
                <div>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div>
                    <select name="payment_status" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                        <option value="">All Payment</option>
                        <option value="pending" {{ request('payment_status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="failed" {{ request('payment_status') === 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="refunded" {{ request('payment_status') === 'refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 flex-wrap items-end">
                <!-- Date Range Presets -->
                <div class="flex flex-wrap gap-2">
                    <button type="button" @click="setRange('today')" class="px-3 py-1.5 text-xs font-medium rounded-lg border border-gray-200 hover:bg-royal-blue hover:text-white hover:border-royal-blue transition-colors">Today</button>
                    <button type="button" @click="setRange('7days')" class="px-3 py-1.5 text-xs font-medium rounded-lg border border-gray-200 hover:bg-royal-blue hover:text-white hover:border-royal-blue transition-colors">Last 7 Days</button>
                    <button type="button" @click="setRange('30days')" class="px-3 py-1.5 text-xs font-medium rounded-lg border border-gray-200 hover:bg-royal-blue hover:text-white hover:border-royal-blue transition-colors">Last 30 Days</button>
                    <button type="button" @click="setRange('thisMonth')" class="px-3 py-1.5 text-xs font-medium rounded-lg border border-gray-200 hover:bg-royal-blue hover:text-white hover:border-royal-blue transition-colors">This Month</button>
                    <button type="button" @click="setRange('lastMonth')" class="px-3 py-1.5 text-xs font-medium rounded-lg border border-gray-200 hover:bg-royal-blue hover:text-white hover:border-royal-blue transition-colors">Last Month</button>
                </div>

                <div class="flex items-center gap-2">
                    <input type="date" name="date_from" x-ref="dateFrom" value="{{ request('date_from') }}"
                           class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                    <span class="text-gray-400 text-sm">to</span>
                    <input type="date" name="date_to" x-ref="dateTo" value="{{ request('date_to') }}"
                           class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                </div>

                <div class="flex gap-2 ml-auto">
                    <button type="submit" class="px-4 py-2 bg-gray-800 text-white text-sm rounded-lg hover:bg-gray-700 transition-colors">Filter</button>
                    <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm rounded-lg hover:bg-gray-200 transition-colors">Reset</a>
                    <a href="{{ route('admin.orders.exportCsv', request()->query()) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Download CSV
                    </a>
                    <a href="{{ route('admin.orders.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-royal-blue text-white text-sm rounded-lg hover:bg-deep-royal transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Create Order
                    </a>
                </div>
            </div>
        </form>
    </div>

    <script>
        function orderFilters() {
            return {
                setRange(preset) {
                    const today = new Date();
                    let from, to;

                    switch(preset) {
                        case 'today':
                            from = to = this.formatDate(today);
                            break;
                        case '7days':
                            to = this.formatDate(today);
                            from = this.formatDate(new Date(today.getTime() - 7 * 86400000));
                            break;
                        case '30days':
                            to = this.formatDate(today);
                            from = this.formatDate(new Date(today.getTime() - 30 * 86400000));
                            break;
                        case 'thisMonth':
                            from = this.formatDate(new Date(today.getFullYear(), today.getMonth(), 1));
                            to = this.formatDate(today);
                            break;
                        case 'lastMonth':
                            from = this.formatDate(new Date(today.getFullYear(), today.getMonth() - 1, 1));
                            to = this.formatDate(new Date(today.getFullYear(), today.getMonth(), 0));
                            break;
                    }

                    this.$refs.dateFrom.value = from;
                    this.$refs.dateTo.value = to;
                },
                formatDate(d) {
                    return d.toISOString().split('T')[0];
                }
            }
        }
    </script>

    <!-- Orders Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @if($orders->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">Order #</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">Customer</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">Items</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">Total</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">Status</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">Payment</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">Txn ID</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">Date</th>
                            <th class="text-right px-6 py-3 font-medium text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($orders as $order)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="font-semibold text-royal-blue hover:text-deep-royal">
                                        {{ $order->order_number }}
                                    </a>
                                    @foreach($order->items as $item)
                                        <div class="text-xs text-gray-400 mt-0.5">{{ $item->product->title ?? 'N/A' }} × {{ $item->quantity }}</div>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $order->customer_name }}</div>
                                    <div class="text-xs text-gray-500">{{ $order->customer_email }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-gray-700">{{ $order->items->sum('quantity') }} item{{ $order->items->sum('quantity') > 1 ? 's' : '' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-semibold text-gray-900">₹{{ number_format($order->total, 2) }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        @php
                                            $statusStyles = [
                                                'pending' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                                'processing' => 'bg-blue-50 text-blue-700 border-blue-200',
                                                'shipped' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                                'delivered' => 'bg-green-50 text-green-700 border-green-200',
                                                'cancelled' => 'bg-red-50 text-red-700 border-red-200',
                                            ];
                                        @endphp
                                        <select name="status" onchange="this.form.submit()"
                                                class="text-xs font-medium rounded-full px-2.5 py-1 border cursor-pointer appearance-none {{ $statusStyles[$order->status] ?? 'bg-gray-50 text-gray-700 border-gray-200' }}">
                                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="px-6 py-4">
                                    <form method="POST" action="{{ route('admin.orders.updatePaymentStatus', $order) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        @php
                                            $payStyles = [
                                                'pending' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                                'paid' => 'bg-green-50 text-green-700 border-green-200',
                                                'failed' => 'bg-red-50 text-red-700 border-red-200',
                                                'refunded' => 'bg-purple-50 text-purple-700 border-purple-200',
                                            ];
                                        @endphp
                                        <select name="payment_status" onchange="this.form.submit()"
                                                class="text-xs font-medium rounded-full px-2.5 py-1 border cursor-pointer appearance-none {{ $payStyles[$order->payment_status] ?? 'bg-gray-50 text-gray-700 border-gray-200' }}">
                                            <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                                            <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Failed</option>
                                            <option value="refunded" {{ $order->payment_status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="px-6 py-4">
                                    @if($order->transaction_id)
                                        <code class="text-xs bg-gray-100 text-gray-700 px-1.5 py-0.5 rounded font-mono">{{ $order->transaction_id }}</code>
                                    @else
                                        <span class="text-xs text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-gray-700">{{ $order->created_at->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-400">{{ $order->created_at->format('h:i A') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('admin.orders.show', $order) }}"
                                           class="p-2 text-gray-500 hover:text-royal-blue hover:bg-blue-50 rounded-lg transition-colors" title="View">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST"
                                              onsubmit="return confirm('Are you sure you want to delete this order?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-gray-500 hover:text-divine-red hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $orders->links() }}
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <h3 class="text-sm font-medium text-gray-900 mb-1">No orders found</h3>
                <p class="text-sm text-gray-500">Orders will appear here once customers start placing them.</p>
            </div>
        @endif
    </div>
@endsection
