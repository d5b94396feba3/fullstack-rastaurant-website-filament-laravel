<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::with(['menuItems' => function ($query) {
            $query->where('is_available', true);
        }])->where('is_active', true)->get();

        $settings = Setting::pluck('value', 'key')->toArray();

        return view('welcome', compact('categories', 'settings'));
    }
}