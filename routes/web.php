<?php

use App\Models\Category;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

// 1. Root URL serves index.blade.php with full categories and settings
Route::get('/', function () {
    $categories = Category::with(['menuItems' => function ($query) {
        $query->where('is_available', true);
    }])->where('is_active', true)->get();

    $settings = Setting::pluck('value', 'key')->toArray();

    return view('index', compact('categories', 'settings'));
});

// 2. Checkout Route
Route::post('/checkout', function (Request $request) {
    return back()->with('success', 'Order received!');
})->name('checkout');

// 3. Reservation Route
Route::post('/reserve', function (Request $request) {
    return back()->with('success', 'Reservation request received!');
})->name('reservations.store');

// 4. Special explicit static-like slug routes (Must come BEFORE /{slug})
Route::get('/home', function () {
    $categories = Category::with(['menuItems' => function ($query) {
        $query->where('is_available', true);
    }])->where('is_active', true)->get();

    $settings = Setting::pluck('value', 'key')->toArray();

    return view('index', compact('categories', 'settings'));
});

// 5. General Dynamic Database CMS Pages Route (/about, /contact, etc.)
Route::get('/{slug}', function ($slug) {
    $page = Page::where('slug', $slug)->firstOrFail();
    $settings = Setting::pluck('value', 'key')->toArray();

    return view('page', compact('page', 'settings'));
});

// 6. Terminal-Free Setup Route for Client Deployment
Route::get('/system-setup-run', function () {
    Artisan::call('migrate --force');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');

    if (! file_exists(public_path('storage'))) {
        app('files')->link(storage_path('app/public'), public_path('storage'));
    }

    return 'System migration, cache clear, and storage symlink executed successfully!';
});