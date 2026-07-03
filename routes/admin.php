<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\BulkUploadController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\EnquiryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\CouponController;
use Illuminate\Support\Facades\Route;

// Admin Guest Routes (redirect to dashboard if already logged in)
Route::middleware('admin.guest')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
});

// Admin Authenticated Routes
Route::middleware('admin.auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // Categories
    Route::resource('categories', CategoryController::class)->except(['show'])->names('admin.categories');

    // Products
    Route::resource('products', ProductController::class)->except(['show'])->names('admin.products');

    // Bulk Upload
    Route::get('bulk-upload', [BulkUploadController::class, 'index'])->name('admin.bulk-upload.index');
    Route::get('bulk-upload/template', [BulkUploadController::class, 'template'])->name('admin.bulk-upload.template');
    Route::post('bulk-upload', [BulkUploadController::class, 'upload'])->name('admin.bulk-upload.upload');

    // Stock Management
    Route::get('stocks', [StockController::class, 'index'])->name('admin.stocks.index');
    Route::get('stocks/{product}/manage', [StockController::class, 'manage'])->name('admin.stocks.manage');
    Route::post('stocks/{product}/manage', [StockController::class, 'save'])->name('admin.stocks.save');

    // Sliders
    Route::resource('sliders', SliderController::class)->except(['show'])->names('admin.sliders');

    // Orders
    Route::get('orders', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::get('orders/create', [OrderController::class, 'create'])->name('admin.orders.create');
    Route::post('orders', [OrderController::class, 'store'])->name('admin.orders.store');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::patch('orders/{order}/payment-status', [OrderController::class, 'updatePaymentStatus'])->name('admin.orders.updatePaymentStatus');
    Route::patch('orders/{order}/shipping', [OrderController::class, 'updateShipping'])->name('admin.orders.updateShipping');
    Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('admin.orders.destroy');
    Route::get('orders-export/csv', [OrderController::class, 'exportCsv'])->name('admin.orders.exportCsv');
    Route::get('orders-print/addresses', [OrderController::class, 'printAddresses'])->name('admin.orders.printAddresses');

    // Blog Categories
    Route::resource('blog-categories', BlogCategoryController::class)->except(['show'])->names('admin.blog-categories');

    // Blogs
    Route::resource('blogs', BlogController::class)->except(['show'])->names('admin.blogs');

    // Enquiries
    Route::get('enquiries', [EnquiryController::class, 'index'])->name('admin.enquiries.index');
    Route::get('enquiries/{enquiry}', [EnquiryController::class, 'show'])->name('admin.enquiries.show');
    Route::delete('enquiries/{enquiry}', [EnquiryController::class, 'destroy'])->name('admin.enquiries.destroy');

    // Media Manager
    Route::get('media', [MediaController::class, 'index'])->name('admin.media.index');
    Route::get('media/api', [MediaController::class, 'api'])->name('admin.media.api');
    Route::post('media/upload', [MediaController::class, 'upload'])->name('admin.media.upload');
    Route::put('media/{medium}', [MediaController::class, 'update'])->name('admin.media.update');
    Route::delete('media/{medium}', [MediaController::class, 'destroy'])->name('admin.media.destroy');
    Route::post('media/bulk-delete', [MediaController::class, 'bulkDelete'])->name('admin.media.bulkDelete');

    // Coupons
    Route::resource('coupons', CouponController::class)->except(['show'])->names('admin.coupons');

    // Site Settings
    Route::get('settings', [SiteSettingController::class, 'index'])->name('admin.settings.index');
    Route::put('settings', [SiteSettingController::class, 'update'])->name('admin.settings.update');
});
