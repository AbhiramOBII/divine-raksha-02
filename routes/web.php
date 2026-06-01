<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/shop-by-purpose/{purpose?}', [ProductController::class, 'shopByPurpose'])->name('shop.purpose');
Route::get('/shop-by-raashi/{raashi?}', [ProductController::class, 'shopByRaashi'])->name('shop.raashi');
Route::get('/shop-by-numerology/{number?}', [ProductController::class, 'shopByNumerology'])->name('shop.numerology');
Route::get('/bestsellers', [ProductController::class, 'bestsellers'])->name('shop.bestsellers');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/search/suggestions', [ProductController::class, 'suggestions'])->name('search.suggestions');

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');

// Coupon
Route::post('/coupon/apply', [App\Http\Controllers\CouponController::class, 'apply'])->name('coupon.apply');
Route::post('/coupon/remove', [App\Http\Controllers\CouponController::class, 'remove'])->name('coupon.remove');

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');
Route::get('/checkout/success/{orderNumber}', [CheckoutController::class, 'success'])->name('checkout.success');

// Razorpay Payment
Route::post('/payment/create-order', [App\Http\Controllers\PaymentController::class, 'createOrder'])->name('payment.createOrder');
Route::post('/payment/verify', [App\Http\Controllers\PaymentController::class, 'verify'])->name('payment.verify');
Route::get('/payment/failed/{orderNumber}', [App\Http\Controllers\PaymentController::class, 'failed'])->name('payment.failed');

// Razorpay Webhook (CSRF excluded in bootstrap/app.php)
Route::post('/webhook/razorpay', [App\Http\Controllers\RazorpayWebhookController::class, 'handle'])->name('webhook.razorpay');
Route::get('/webhook/razorpay', fn () => response()->json(['status' => 'Webhook endpoint active. POST only.']));

// Sitemap
Route::get('/sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');
Route::get('/sitemap-pages.xml', [App\Http\Controllers\SitemapController::class, 'pages']);
Route::get('/sitemap-products.xml', [App\Http\Controllers\SitemapController::class, 'products']);
Route::get('/sitemap-blogs.xml', [App\Http\Controllers\SitemapController::class, 'blogs']);

// About
Route::view('/about', 'about')->name('about');

// FAQ
Route::view('/faq', 'faq')->name('faq');

// Legal Pages
Route::view('/terms-of-use', 'pages.terms')->name('terms');
Route::view('/privacy-policy', 'pages.privacy')->name('privacy');
Route::view('/disclaimer', 'pages.disclaimer')->name('disclaimer');
Route::view('/return-policy', 'pages.return-policy')->name('return-policy');
Route::view('/care-instructions', 'pages.care-instructions')->name('care-instructions');

// Blogs
Route::get('/blogs', [App\Http\Controllers\BlogController::class, 'index'])->name('blogs.index');
Route::get('/blogs/category/{category:slug}', [App\Http\Controllers\BlogController::class, 'category'])->name('blogs.category');
Route::get('/blogs/{blog:slug}', [App\Http\Controllers\BlogController::class, 'show'])->name('blogs.show');

// Contact
Route::get('/contact', [App\Http\Controllers\ContactController::class, 'index'])->name('contact');
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'submit'])->name('contact.submit');

// Track Order
Route::get('/track-order', [App\Http\Controllers\OrderTrackController::class, 'index'])->name('order.track');
Route::post('/track-order', [App\Http\Controllers\OrderTrackController::class, 'track'])->name('order.track.search');

// Auth (Guest only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Auth (Authenticated)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/email/verify', [AuthController::class, 'verificationNotice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verificationVerify'])->middleware('signed')->name('verification.verify');
    Route::post('/email/resend', [AuthController::class, 'verificationResend'])->middleware('throttle:6,1')->name('verification.resend');
});
