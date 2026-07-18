<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\AlbumController;
use Illuminate\Support\Facades\Route;

// =============================================
// FRONTEND ROUTES
// =============================================
Route::get('/', [HomeController::class, 'index'])->name('home');

// Products
Route::get('/produk', [ProductController::class, 'index'])->name('products.index');
Route::get('/produk/kategori/{slug}', [ProductController::class, 'category'])->name('products.category');
Route::get('/produk/{slug}', [ProductController::class, 'show'])->name('products.show');

// News/Posts
Route::get('/berita', [PostController::class, 'index'])->name('posts.index');
Route::get('/berita/{slug}', [PostController::class, 'show'])->name('posts.show');

// Gallery
Route::get('/galeri', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/galeri/foto/{slug}', [GalleryController::class, 'photos'])->name('gallery.photos');
Route::get('/galeri/video/{slug?}', [GalleryController::class, 'videos'])->name('gallery.videos');

// Testimonials
Route::get('/testimonial', [TestimonialController::class, 'index'])->name('testimonials.index');
Route::post('/testimonial', [TestimonialController::class, 'store'])->name('testimonials.store');

// Orders
Route::get('/order', [OrderController::class, 'create'])->name('order.create');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');

// Contact
Route::get('/kontak', [ContactController::class, 'index'])->name('contact.index');
Route::post('/kontak', [ContactController::class, 'send'])->name('contact.send');

// Static Pages
Route::get('/halaman/{slug}', [PageController::class, 'show'])->name('pages.show');

// Download
Route::get('/download', [DownloadController::class, 'index'])->name('download.index');

// =============================================
// BREEZE AUTH ROUTES
// =============================================
require __DIR__.'/auth.php';

// =============================================
// DASHBOARD (Breeze default)
// =============================================
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// =============================================
// PROFILE (Breeze default)
// =============================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =============================================
// ADMIN CMS ROUTES
// =============================================
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin,editor'])
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('product-categories', ProductCategoryController::class);
        Route::resource('products', AdminProductController::class);
        Route::resource('product-images', ProductImageController::class);
        Route::resource('news', NewsController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('testimonials', AdminTestimonialController::class)->only(['index', 'show', 'update', 'destroy']);
        Route::resource('albums', AlbumController::class);
        Route::post('albums/{album}/photos', [AlbumController::class, 'addPhoto'])->name('albums.photos.store');
        Route::delete('albums/{album}/photos/{photo}', [AlbumController::class, 'deletePhoto'])->name('albums.photos.delete');
    });
