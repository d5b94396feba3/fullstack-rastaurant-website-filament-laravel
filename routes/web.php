<?php

use App\Models\Category;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

// 1. Terminal-Free Setup Route
Route::get('/system-setup-run', function () {
    try {
        Artisan::call('migrate --force');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('route:clear');

        if (! file_exists(public_path('storage'))) {
            app('files')->link(storage_path('app/public'), public_path('storage'));
        }

        return 'System setup executed successfully!';
    } catch (\Exception $e) {
        return 'Setup Error: ' . $e->getMessage();
    }
});

// 2. Main Site Homepage Route
Route::get('/', function () {
    $categories = Category::with(['menuItems' => function ($query) {
        $query->where('is_available', true);
    }])->where('is_active', true)->get();

    $settings = Setting::pluck('value', 'key')->toArray();

    return view('index', compact('categories', 'settings'));
});

// 3. Alternate Home Route
Route::get('/home', function () {
    $categories = Category::with(['menuItems' => function ($query) {
        $query->where('is_available', true);
    }])->where('is_active', true)->get();

    $settings = Setting::pluck('value', 'key')->toArray();

    return view('index', compact('categories', 'settings'));
});

// 4. Checkout Route
Route::post('/checkout', function (Request $request) {
    return back()->with('success', 'Order received!');
})->name('checkout');

// 5. Reservation Route
Route::post('/reserve', function (Request $request) {
    return back()->with('success', 'Reservation request received!');
})->name('reservations.store');

// 6. CMS Dynamic Pages Catch-All Route (Must remain LAST)
Route::get('/{slug}', function ($slug) {
    $page = Page::where('slug', $slug)->firstOrFail();
    $settings = Setting::pluck('value', 'key')->toArray();

    return view('page', compact('page', 'settings'));
});