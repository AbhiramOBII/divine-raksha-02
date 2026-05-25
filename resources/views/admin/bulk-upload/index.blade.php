@extends('admin.layouts.app')

@section('title', 'Bulk Upload Products')
@section('page-title', 'Bulk Upload Products')

@section('content')
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
        <div>
            <p class="text-sm text-gray-500">Upload multiple products at once via CSV file</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.bulk-upload.template') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Download Template
            </a>
            <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Products
            </a>
        </div>
    </div>

    <!-- Results -->
    @if(session('results'))
        @php $results = session('results'); @endphp
        <div class="mb-6 rounded-xl border {{ $results['failed'] > 0 ? 'border-yellow-200 bg-yellow-50' : 'border-green-200 bg-green-50' }} p-5">
            <div class="flex items-start gap-3">
                @if($results['failed'] === 0)
                    <svg class="w-6 h-6 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                @else
                    <svg class="w-6 h-6 text-yellow-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                @endif
                <div class="flex-1">
                    <h3 class="text-sm font-semibold {{ $results['failed'] > 0 ? 'text-yellow-800' : 'text-green-800' }}">
                        Upload Complete
                    </h3>
                    <div class="mt-2 flex flex-wrap gap-4 text-sm">
                        <span class="text-green-700 font-medium">✓ {{ $results['success'] }} products imported</span>
                        @if($results['failed'] > 0)
                            <span class="text-red-700 font-medium">✗ {{ $results['failed'] }} failed</span>
                        @endif
                    </div>
                    @if(!empty($results['errors']))
                        <div class="mt-3 max-h-40 overflow-y-auto">
                            <ul class="text-xs text-red-700 space-y-1">
                                @foreach($results['errors'] as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">
            <p class="text-sm text-red-700">{{ session('error') }}</p>
        </div>
    @endif

    <!-- Upload Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Upload CSV File</h3>
            <p class="text-sm text-gray-500 mt-1">Select a CSV file with product data. Download the template to see the correct format.</p>
        </div>

        <form action="{{ route('admin.bulk-upload.upload') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf

            <div class="max-w-xl">
                <!-- File Input -->
                <div x-data="{ fileName: '' }" class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">CSV File <span class="text-red-500">*</span></label>
                    <div class="flex items-center gap-4">
                        <label class="flex-1 flex items-center px-4 py-3 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-royal-blue hover:bg-royal-blue/5 transition-all duration-200">
                            <svg class="w-6 h-6 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <span class="text-sm text-gray-600" x-text="fileName || 'Choose a CSV file...'"></span>
                            <input type="file" name="csv_file" accept=".csv,.txt" class="hidden"
                                   @change="fileName = $event.target.files[0]?.name || ''">
                        </label>
                    </div>
                    @error('csv_file')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit -->
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-royal-blue text-white text-sm font-semibold rounded-lg hover:bg-blue-800 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                    </svg>
                    Upload & Import Products
                </button>
            </div>
        </form>
    </div>

    <!-- Instructions -->
    <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">CSV Format Instructions</h3>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-left py-2 px-3 font-semibold text-gray-700">Column</th>
                            <th class="text-left py-2 px-3 font-semibold text-gray-700">Required</th>
                            <th class="text-left py-2 px-3 font-semibold text-gray-700">Description</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600">
                        <tr class="border-b border-gray-50">
                            <td class="py-2 px-3 font-mono text-xs bg-gray-50 rounded">title</td>
                            <td class="py-2 px-3"><span class="text-red-500 font-bold">Yes</span></td>
                            <td class="py-2 px-3">Product name</td>
                        </tr>
                        <tr class="border-b border-gray-50">
                            <td class="py-2 px-3 font-mono text-xs bg-gray-50 rounded">category_name</td>
                            <td class="py-2 px-3">No</td>
                            <td class="py-2 px-3">Category name (auto-created if not exists)</td>
                        </tr>
                        <tr class="border-b border-gray-50">
                            <td class="py-2 px-3 font-mono text-xs bg-gray-50 rounded">sku</td>
                            <td class="py-2 px-3">No</td>
                            <td class="py-2 px-3">Product SKU code</td>
                        </tr>
                        <tr class="border-b border-gray-50">
                            <td class="py-2 px-3 font-mono text-xs bg-gray-50 rounded">selling_price</td>
                            <td class="py-2 px-3"><span class="text-red-500 font-bold">Yes</span></td>
                            <td class="py-2 px-3">Selling price (numeric)</td>
                        </tr>
                        <tr class="border-b border-gray-50">
                            <td class="py-2 px-3 font-mono text-xs bg-gray-50 rounded">cost_price</td>
                            <td class="py-2 px-3">No</td>
                            <td class="py-2 px-3">Cost price (numeric)</td>
                        </tr>
                        <tr class="border-b border-gray-50">
                            <td class="py-2 px-3 font-mono text-xs bg-gray-50 rounded">stock</td>
                            <td class="py-2 px-3">No</td>
                            <td class="py-2 px-3">Default stock quantity (numeric, added to product_stocks table)</td>
                        </tr>
                        <tr class="border-b border-gray-50">
                            <td class="py-2 px-3 font-mono text-xs bg-gray-50 rounded">featured / new_product / bestseller / status</td>
                            <td class="py-2 px-3">No</td>
                            <td class="py-2 px-3">Use 1 (yes) or 0 (no)</td>
                        </tr>
                        <tr class="border-b border-gray-50">
                            <td class="py-2 px-3 font-mono text-xs bg-gray-50 rounded">attributes</td>
                            <td class="py-2 px-3">No</td>
                            <td class="py-2 px-3">Pipe-separated: Natural|Blessed|Handcrafted</td>
                        </tr>
                        <tr class="border-b border-gray-50">
                            <td class="py-2 px-3 font-mono text-xs bg-gray-50 rounded">shop_purpose</td>
                            <td class="py-2 px-3">No</td>
                            <td class="py-2 px-3">Pipe-separated: Wealth|Love|Health|Luck|Protection|Peace|Courage|Balance</td>
                        </tr>
                        <tr class="border-b border-gray-50">
                            <td class="py-2 px-3 font-mono text-xs bg-gray-50 rounded">shop_by_raashi</td>
                            <td class="py-2 px-3">No</td>
                            <td class="py-2 px-3">Pipe-separated: Mesha|Vrishabha|Mithuna|Karka|Simha|Kanya|Tula|Vrischika|Dhanu|Makara|Kumbha|Meena</td>
                        </tr>
                        <tr class="border-b border-gray-50">
                            <td class="py-2 px-3 font-mono text-xs bg-gray-50 rounded">shop_by_numerology</td>
                            <td class="py-2 px-3">No</td>
                            <td class="py-2 px-3">Pipe-separated: 1|2|3|4|5|6|7|8|9</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-3 font-mono text-xs bg-gray-50 rounded">size</td>
                            <td class="py-2 px-3">No</td>
                            <td class="py-2 px-3">Pipe-separated: Small|Medium|Large|Extra Large</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-4 p-4 bg-blue-50 border border-blue-100 rounded-lg">
                <p class="text-xs text-blue-700">
                    <strong>Note:</strong> For multi-value fields (attributes, purpose, raashi, numerology, size), use the pipe character <code class="bg-blue-100 px-1 rounded">|</code> to separate values. 
                    Slugs are auto-generated from titles. Images can be added later from the product edit page.
                </p>
            </div>
        </div>
    </div>
@endsection
