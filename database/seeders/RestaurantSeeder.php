<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class RestaurantSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Core Site Settings (FLAVOR HARBOR Branding)
        $settings = [
            'site_name' => 'FLAVOR HARBOR',
            'hero_title' => 'Delicious Pastas & Restaurant System',
            'hero_subtitle' => 'Handcrafted daily using organic ingredients, authentic Italian recipes, and served fresh at your table or delivered directly to your doorstep.',
            'announcement_text' => 'Get 15% off your first online order!',
            'hero_banner' => 'https://images.unsplash.com/photo-1551183053-bf91a1d81141?auto=format&fit=crop&w=1920&q=80',
            'doordash_url' => 'https://www.doordash.com',
            'ubereats_url' => 'https://www.ubereats.com',
            'grubhub_url' => 'https://www.grubhub.com',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // 2. Mandatory Pages
        Page::updateOrCreate(['slug' => 'our-story'], [
            'title' => 'Our Story',
            'content' => '<h2>A Legacy of Culinary Excellence</h2><p>Founded with a passion for gastronomy, FLAVOR HARBOR brings together handcrafted pastas, aged prime cuts, and fresh local produce under one roof.</p>',
            'meta_title' => 'Our Story | FLAVOR HARBOR',
            'meta_description' => 'Learn about our culinary heritage and farm-to-table philosophy.',
        ]);

        Page::updateOrCreate(['slug' => 'contact-us'], [
            'title' => 'Contact & Hours',
            'content' => '<h2>Visit Us</h2><p><strong>Address:</strong> 123 Harbor Boulevard, New York, NY 10001</p><p><strong>Phone:</strong> (555) 019-2831</p><p><strong>Hours:</strong> Mon - Sun: 11:00 AM - 10:00 PM</p>',
            'meta_title' => 'Contact Us | FLAVOR HARBOR',
            'meta_description' => 'Get in touch with FLAVOR HARBOR for reservations and catering.',
        ]);

        // 3. Reset & Reseed Categories & Menu Items
        Category::query()->delete();
        MenuItem::query()->delete();

        // Category 1: Special Dishes (Matches Proposal Mockup Items)
        $specials = Category::create(['name' => 'Special Dishes', 'slug' => 'special-dishes', 'is_active' => true]);
        
        MenuItem::create([
            'category_id' => $specials->id,
            'name' => 'Herb Roasted Salmon',
            'description' => 'Pan-roasted Atlantic salmon served with wild herbs, garlic butter, and fresh seasonal greens.',
            'price' => 14.00,
            'image' => 'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?auto=format&fit=crop&w=800&q=80',
            'is_available' => true,
        ]);

        MenuItem::create([
            'category_id' => $specials->id,
            'name' => 'Steak Frites',
            'description' => 'Prime cut tenderloin grilled to perfection, accompanied by seasoned hand-cut fries and garlic herb butter.',
            'price' => 15.40,
            'image' => 'https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=800&q=80',
            'is_available' => true,
        ]);

        MenuItem::create([
            'category_id' => $specials->id,
            'name' => 'Seafood Dishes',
            'description' => 'A rich selection of fresh catch including seared ahi tuna, tiger prawns, and microgreens in citrus glaze.',
            'price' => 17.00,
            'image' => 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?auto=format&fit=crop&w=800&q=80',
            'is_available' => true,
        ]);

        // Category 2: Pastas
        $pastas = Category::create(['name' => 'Signature Pastas', 'slug' => 'signature-pastas', 'is_active' => true]);

        MenuItem::create([
            'category_id' => $pastas->id,
            'name' => 'Artisanal Spaghetti Pomodoro',
            'description' => 'Hand-spun spaghetti, San Marzano tomatoes, fresh basil leaves, and shaved Parmigiano-Reggiano.',
            'price' => 16.50,
            'image' => 'https://images.unsplash.com/photo-1551183053-bf91a1d81141?auto=format&fit=crop&w=800&q=80',
            'is_available' => true,
        ]);

        MenuItem::create([
            'category_id' => $pastas->id,
            'name' => 'Truffle Burrata Fettuccine',
            'description' => 'Creamy burrata, shaved black truffle, wild mushroom ragu, and freshly cracked pepper.',
            'price' => 19.00,
            'image' => 'https://images.unsplash.com/photo-1540420773420-3366772f4999?auto=format&fit=crop&w=800&q=80',
            'is_available' => true,
        ]);
    }
}