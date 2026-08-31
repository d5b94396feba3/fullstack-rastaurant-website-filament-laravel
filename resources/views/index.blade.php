@extends('layouts.app')

@section('content')
    <!-- Dynamic Hero Section -->
    <section id="home" class="relative bg-slate-950 text-white min-h-[680px] lg:min-h-[780px] flex items-center overflow-hidden border-b border-slate-900">
        <div class="absolute inset-0 bg-cover bg-center z-0 scale-105 transform transition duration-1000" style="background-image: url('{{ $settings['hero_image'] ?? 'https://images.unsplash.com/photo-1551183053-bf91a1d81141?auto=format&fit=crop&w=1920&q=80' }}')"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-950/85 to-transparent z-10"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent to-slate-950/50 z-10"></div>

        <div class="relative z-20 max-w-7xl mx-auto px-6 py-24 w-full">
            <div class="max-w-2xl transform transition-all duration-1000 ease-out translate-y-0 opacity-100">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-slate-900/80 border border-amber-500/30 text-amber-400 font-bold uppercase tracking-widest text-[11px] mb-6 backdrop-blur-md shadow-lg shadow-amber-500/10 hover:scale-105 transition duration-300">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                    {{ $settings['hero_badge'] ?? 'Authentic Culinary Crafts' }}
                </div>
                <h1 class="text-4xl sm:text-6xl lg:text-7xl font-extrabold text-white leading-[1.1] mb-6 font-serif tracking-tight drop-shadow-md">
                    {{ $settings['hero_title'] ?? 'Handcrafted Pastas & Coastal Flavors' }}
                </h1>
                <p class="text-slate-300 text-base md:text-xl mb-10 font-normal leading-relaxed text-slate-300/90 font-sans">
                    {{ $settings['hero_subtitle'] ?? 'Immerse yourself in artisanal Italian recipes crafted daily with wild-caught seafood, house-made pastas, and locally sourced organic ingredients.' }}
                </p>
                <div class="flex flex-wrap items-center gap-4">
                    <a href="#reserve" class="bg-gradient-to-r from-brand-orange to-amber-600 hover:from-brand-orangeHover hover:to-amber-700 text-white font-bold px-8 py-4 rounded-full text-xs uppercase tracking-wider transition-all duration-300 shadow-2xl shadow-brand-orange/30 transform hover:-translate-y-1 hover:scale-105 active:translate-y-0">
                        Reserve Table
                    </a>
                    <a href="#menu" class="border border-white/20 hover:border-white text-white hover:bg-white/10 font-bold px-8 py-4 rounded-full text-xs uppercase tracking-wider transition-all duration-300 bg-slate-900/40 backdrop-blur-md shadow-lg transform hover:-translate-y-1 hover:scale-105">
                        Explore Menu
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Key Highlights / Micro Features Bar -->
    <section class="bg-slate-900 border-b border-slate-800 text-slate-300 py-6 text-xs font-semibold">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div class="flex items-center justify-center gap-3 transform hover:scale-105 transition duration-300 cursor-pointer">
                <span class="text-xl transform hover:rotate-12 transition duration-300">🌿</span>
                <span class="uppercase tracking-wider hover:text-white transition">100% Organic Produce</span>
            </div>
            <div class="flex items-center justify-center gap-3 transform hover:scale-105 transition duration-300 cursor-pointer">
                <span class="text-xl transform hover:rotate-12 transition duration-300">🍝</span>
                <span class="uppercase tracking-wider hover:text-white transition">Fresh Daily Dough</span>
            </div>
            <div class="flex items-center justify-center gap-3 transform hover:scale-105 transition duration-300 cursor-pointer">
                <span class="text-xl transform hover:rotate-12 transition duration-300">🍷</span>
                <span class="uppercase tracking-wider hover:text-white transition">Sommelier Selection</span>
            </div>
            <div class="flex items-center justify-center gap-3 transform hover:scale-105 transition duration-300 cursor-pointer">
                <span class="text-xl transform hover:rotate-12 transition duration-300">⭐</span>
                <span class="uppercase tracking-wider hover:text-white transition">Top Rated Dining</span>
            </div>
        </div>
    </section>

    <!-- Dynamic Special Dishes Section -->
    <section id="menu" class="py-24 max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
            <div>
                <span class="text-brand-orange font-bold uppercase tracking-widest text-xs block mb-2">{{ $settings['menu_badge'] ?? 'Chef Specials' }}</span>
                <h2 class="text-3xl sm:text-5xl font-extrabold text-slate-900 font-serif tracking-tight">{{ $settings['menu_heading'] ?? 'Featured Culinary Creations' }}</h2>
            </div>
            <p class="text-slate-500 text-sm max-w-md mt-4 md:mt-0 leading-relaxed">{{ $settings['menu_subheading'] ?? 'Made fresh daily using traditional methods passed down through generations.' }}</p>
        </div>

        <!-- Dynamic Category Filter Buttons -->
        <div class="flex flex-wrap gap-2.5 mb-12 border-b border-slate-200 pb-6">
            <button @click="activeTab = 'all'" 
                    :class="activeTab === 'all' ? 'bg-slate-900 text-white ring-2 ring-slate-900 scale-105 shadow-md' : 'bg-white text-slate-600 border border-slate-200 hover:border-slate-400 hover:text-slate-900 hover:scale-105'"
                    class="px-6 py-2.5 rounded-full font-bold text-xs uppercase tracking-wider transition-all duration-300 shadow-sm transform">
                All Specialties
            </button>

            @if(isset($categories) && count($categories) > 0)
                @foreach($categories as $category)
                    <button @click="activeTab = 'cat-{{ $category->id }}'" 
                            :class="activeTab === 'cat-{{ $category->id }}' ? 'bg-slate-900 text-white ring-2 ring-slate-900 scale-105 shadow-md' : 'bg-white text-slate-600 border border-slate-200 hover:border-slate-400 hover:text-slate-900 hover:scale-105'"
                            class="px-6 py-2.5 rounded-full font-bold text-xs uppercase tracking-wider transition-all duration-300 shadow-sm transform">
                        {{ $category->name }}
                    </button>
                @endforeach
            @endif
        </div>

        <!-- Dynamic Menu Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Executive Story Highlight Card -->
            <div class="bg-gradient-to-b from-slate-900 to-slate-950 rounded-2xl overflow-hidden shadow-2xl flex flex-col justify-between text-white border border-slate-800 hover:border-amber-500/60 hover:-translate-y-2 transition-all duration-500 group">
                <div class="h-60 overflow-hidden relative">
                    <img src="{{ $settings['story_image'] ?? 'https://images.unsplash.com/photo-1577219491135-ce391730fb2c?auto=format&fit=crop&w=600&q=80' }}" alt="Executive Chef" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <span class="text-amber-400 font-bold text-[10px] uppercase tracking-widest block mb-1">{{ $settings['story_role'] ?? 'Executive Chef' }}</span>
                        <h3 class="text-2xl font-bold font-serif mb-2 text-white">{{ $settings['story_title'] ?? 'Artisanal Tradition' }}</h3>
                        <p class="text-xs text-slate-400 leading-relaxed mb-6">{{ $settings['story_description'] ?? 'Every plate is curated with wild-caught seafood and house-rolled dough crafted every morning.' }}</p>
                    </div>
                    <a href="#about" class="text-brand-orange text-xs font-bold uppercase tracking-wider inline-flex items-center gap-2 group-hover:translate-x-1.5 transition duration-300">
                        <span>Read Our Full Story</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            </div>

            <!-- Database Menu Items Loop -->
            @if(isset($categories) && count($categories) > 0)
                @foreach($categories as $category)
                    @if(isset($category->menuItems) && count($category->menuItems) > 0)
                        @foreach($category->menuItems as $item)
                            <div class="bg-white rounded-2xl overflow-hidden border border-slate-200/80 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 flex flex-col justify-between group" 
                                 x-show="activeTab === 'all' || activeTab === 'cat-{{ $category->id }}'" x-transition>
                                <div>
                                    <div class="h-60 bg-slate-100 overflow-hidden relative">
                                        @if(!empty($item->image))
                                            <img src="{{ Str::startsWith($item->image, 'http') ? $item->image : asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-slate-100 text-slate-400 text-xs font-bold uppercase tracking-wider">Image Coming Soon</div>
                                        @endif
                                        <div class="absolute top-3 right-3 bg-slate-950/90 backdrop-blur-md text-amber-400 font-black text-xs px-3.5 py-1.5 rounded-full border border-amber-500/20 shadow-lg transform group-hover:scale-105 transition duration-300">
                                            ${{ number_format($item->price, 2) }}
                                        </div>
                                    </div>
                                    <div class="p-6">
                                        <h4 class="font-bold text-slate-900 text-lg mb-2 font-serif leading-snug group-hover:text-brand-orange transition duration-300">{{ $item->name }}</h4>
                                        <p class="text-xs text-slate-500 leading-relaxed mb-4 line-clamp-3 font-normal">{{ $item->description }}</p>
                                    </div>
                                </div>
                                <div class="px-6 pb-6">
                                    <button @click="addToCart({ id: {{ $item->id }}, name: '{{ addslashes($item->name) }}', price: {{ $item->price }} })"
                                            class="w-full bg-slate-900 hover:bg-brand-orange text-white font-bold py-3 rounded-xl text-xs uppercase tracking-wider transition-all duration-300 shadow-md transform hover:scale-[1.02] active:scale-[0.98]">
                                        Add To Order
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @endif
                @endforeach
            @endif
        </div>
    </section>

    <!-- Dynamic Delivery Partner Section -->
    <section id="order" class="py-20 bg-slate-900 border-y border-slate-800 text-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 text-center relative z-10">
            <span class="text-amber-400 font-bold uppercase tracking-widest text-xs block mb-2">{{ $settings['delivery_badge'] ?? 'Direct Delivery & Takeout' }}</span>
            <h3 class="text-3xl sm:text-4xl font-extrabold text-white font-serif mb-8">{{ $settings['delivery_heading'] ?? 'Enjoy Flavor Harbor at Home' }}</h3>
            <div class="flex flex-wrap justify-center gap-5">
                @if(!empty($settings['doordash_url']))
                    <a href="{{ $settings['doordash_url'] }}" target="_blank" class="bg-red-600 hover:bg-red-700 text-white font-bold px-8 py-4 rounded-full text-xs uppercase tracking-wider shadow-lg transition-all duration-300 transform hover:-translate-y-1 hover:scale-105">
                        Order via DoorDash
                    </a>
                @endif
                @if(!empty($settings['ubereats_url']))
                    <a href="{{ $settings['ubereats_url'] }}" target="_blank" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-8 py-4 rounded-full text-xs uppercase tracking-wider shadow-lg transition-all duration-300 transform hover:-translate-y-1 hover:scale-105">
                        Order via Uber Eats
                    </a>
                @endif
                @if(!empty($settings['grubhub_url']))
                    <a href="{{ $settings['grubhub_url'] }}" target="_blank" class="bg-orange-500 hover:bg-orange-600 text-white font-bold px-8 py-4 rounded-full text-xs uppercase tracking-wider shadow-lg transition-all duration-300 transform hover:-translate-y-1 hover:scale-105">
                        Order via Grubhub
                    </a>
                @endif
            </div>
        </div>
    </section>

    <!-- Dynamic About & Story Section -->
    <section id="about" class="py-24 max-w-7xl mx-auto px-6 border-b border-slate-200">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div class="grid grid-cols-2 gap-4 relative">
                <img src="{{ $settings['about_image_1'] ?? 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=800&q=80' }}" alt="Dining Room" class="rounded-2xl shadow-xl h-80 w-full object-cover transform hover:scale-105 transition duration-700">
                <img src="{{ $settings['about_image_2'] ?? 'https://images.unsplash.com/photo-1550966871-3ed3cdb5ed0c?auto=format&fit=crop&w=800&q=80' }}" alt="Restaurant Atmosphere" class="rounded-2xl shadow-xl h-80 w-full object-cover mt-10 transform hover:scale-105 transition duration-700">
            </div>
            <div>
                <span class="text-brand-orange font-bold uppercase tracking-widest text-xs block mb-2">{{ $settings['about_badge'] ?? 'Our Heritage' }}</span>
                <h2 class="text-3xl sm:text-5xl font-extrabold text-slate-900 font-serif mb-6 leading-tight">{{ $settings['about_heading'] ?? 'A Passion for Culinary Craftsmanship' }}</h2>
                <p class="text-slate-600 text-base leading-relaxed mb-4">
                    {{ $settings['about_paragraph_1'] ?? 'Founded in the heart of the city, FLAVOR HARBOR was built on a simple promise: bringing authentic Mediterranean techniques and coastal ingredients to your table.' }}
                </p>
                <p class="text-slate-600 text-base leading-relaxed mb-8">
                    {{ $settings['about_paragraph_2'] ?? 'Every dish tells a story. From hand-crafted pasta prepared from scratch each morning to rare cuts of prime meats aged to perfection, our kitchen works in harmony with organic local farms to ensure uncompromised quality.' }}
                </p>
                <div class="grid grid-cols-3 gap-6 text-center border-t border-slate-200 pt-8">
                    <div class="transform hover:scale-105 transition duration-300">
                        <div class="text-3xl font-black text-slate-900 font-serif text-brand-orange">{{ $settings['stat_1_val'] ?? '100%' }}</div>
                        <div class="text-[11px] text-slate-500 font-bold uppercase tracking-wider mt-1">{{ $settings['stat_1_lbl'] ?? 'Fresh Ingredients' }}</div>
                    </div>
                    <div class="transform hover:scale-105 transition duration-300">
                        <div class="text-3xl font-black text-slate-900 font-serif text-brand-orange">{{ $settings['stat_2_val'] ?? '15+' }}</div>
                        <div class="text-[11px] text-slate-500 font-bold uppercase tracking-wider mt-1">{{ $settings['stat_2_lbl'] ?? 'Years Excellence' }}</div>
                    </div>
                    <div class="transform hover:scale-105 transition duration-300">
                        <div class="text-3xl font-black text-slate-900 font-serif text-brand-orange">{{ $settings['stat_3_val'] ?? '4.9★' }}</div>
                        <div class="text-[11px] text-slate-500 font-bold uppercase tracking-wider mt-1">{{ $settings['stat_3_lbl'] ?? 'Customer Rating' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Social Proof & Customer Reviews Section -->
    <section class="py-24 bg-slate-900 text-white border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <span class="text-amber-400 font-bold uppercase tracking-widest text-xs block mb-2">Guest Testimonials</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold font-serif mb-16">Unforgettable Dining Experiences</h2>
            
            <div class="grid md:grid-cols-3 gap-8 text-left">
                <div class="bg-slate-950 p-8 rounded-2xl border border-slate-800 shadow-xl hover:border-amber-500/50 hover:-translate-y-2 transition-all duration-500 group">
                    <div class="flex text-amber-400 mb-4 text-sm group-hover:scale-105 transition origin-left">★★★★★</div>
                    <p class="text-slate-300 text-sm leading-relaxed mb-6 font-normal">"The wild-caught seafood pasta was absolutely divine. The atmosphere hits the perfect balance between modern elegance and cozy warmth."</p>
                    <div class="font-bold text-sm text-white font-serif">— Elena Rostova</div>
                    <div class="text-xs text-slate-500">Verified Diner</div>
                </div>
                <div class="bg-slate-950 p-8 rounded-2xl border border-slate-800 shadow-xl hover:border-amber-500/50 hover:-translate-y-2 transition-all duration-500 group">
                    <div class="flex text-amber-400 mb-4 text-sm group-hover:scale-105 transition origin-left">★★★★★</div>
                    <p class="text-slate-300 text-sm leading-relaxed mb-6 font-normal">"Without a doubt the finest dining experience in the area. Reservation process was smooth, and the wine pairings were spot on."</p>
                    <div class="font-bold text-sm text-white font-serif">— Marcus Vance</div>
                    <div class="text-xs text-slate-500">Food & Wine Critic</div>
                </div>
                <div class="bg-slate-950 p-8 rounded-2xl border border-slate-800 shadow-xl hover:border-amber-500/50 hover:-translate-y-2 transition-all duration-500 group">
                    <div class="flex text-amber-400 mb-4 text-sm group-hover:scale-105 transition origin-left">★★★★★</div>
                    <p class="text-slate-300 text-sm leading-relaxed mb-6 font-normal">"Hands down the best artisanal kitchen in town. The attention to detail in every single dish makes it worth every visit."</p>
                    <div class="font-bold text-sm text-white font-serif">— Sarah Jenkins</div>
                    <div class="text-xs text-slate-500">Local Foodie</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Dynamic Hours & Location Section -->
    <section id="hours" class="py-24 bg-slate-100 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-16 items-center">
            <div>
                <span class="text-brand-orange font-bold uppercase tracking-widest text-xs block mb-2">Visit Us</span>
                <h3 class="text-3xl sm:text-4xl font-extrabold text-slate-900 font-serif mb-8">Hours & Location</h3>
                <div class="space-y-4 text-sm text-slate-600 bg-white p-8 rounded-2xl shadow-sm border border-slate-200 hover:shadow-lg transition duration-300">
                    <div class="flex justify-between border-b border-slate-100 pb-3">
                        <span class="font-bold text-slate-900">Monday – Thursday:</span>
                        <span class="font-medium">{{ $settings['hours_weekday'] ?? '11:30 AM – 10:00 PM' }}</span>
                    </div>
                    <div class="flex justify-between border-b border-slate-100 pb-3">
                        <span class="font-bold text-slate-900">Friday – Saturday:</span>
                        <span class="font-medium text-brand-orange">{{ $settings['hours_weekend'] ?? '11:30 AM – 11:00 PM' }}</span>
                    </div>
                    <div class="flex justify-between pb-1">
                        <span class="font-bold text-slate-900">Sunday:</span>
                        <span class="font-medium">{{ $settings['hours_sunday'] ?? '10:30 AM – 9:00 PM' }}</span>
                    </div>
                </div>
                <div class="mt-8 text-sm bg-slate-900 text-white p-8 rounded-2xl shadow-lg border border-slate-800 hover:border-amber-500/40 transition duration-300">
                    <p class="font-bold text-white text-base font-serif mb-1">{{ $settings['site_name'] ?? 'Flavor Harbor Restaurant' }}</p>
                    <p class="text-slate-300 leading-relaxed">{{ $settings['address_line_1'] ?? '124 Harbor View Boulevard, Suite 100' }}</p>
                    <p class="text-slate-300 leading-relaxed">{{ $settings['address_line_2'] ?? 'Coastal City, CA 90210' }}</p>
                </div>
            </div>
            <div class="bg-slate-300 rounded-2xl h-96 overflow-hidden shadow-xl border border-slate-300 relative transform hover:scale-[1.01] transition duration-500">
                <iframe class="w-full h-full border-0" src="{{ $settings['maps_embed_url'] ?? 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.83543450937!2d-122.4194155!3d37.774929!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zM!5e0!3m2!1sen!2sus!4v1620000000000!5m2!1sen!2sus' }}" loading="lazy" aria-label="Restaurant Map Location"></iframe>
            </div>
        </div>
    </section>

    <!-- Dynamic Reservation Section -->
    <section id="reserve" class="py-24 bg-slate-950 text-white relative">
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-center mb-12">
                <span class="text-amber-400 font-bold uppercase tracking-widest text-xs block mb-2">{{ $settings['reservation_badge'] ?? 'Table Booking' }}</span>
                <h2 class="text-3xl md:text-5xl font-extrabold font-serif mb-4">{{ $settings['reservation_heading'] ?? 'Reserve Your Experience' }}</h2>
                <p class="text-slate-400 text-sm font-normal max-w-lg mx-auto">{{ $settings['reservation_subheading'] ?? 'For parties larger than 8 or private dining inquiries, please contact our events team directly.' }}</p>
            </div>

            <form action="{{ Route::has('reservations.store') ? route('reservations.store') : '/reserve' }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-900 p-8 sm:p-10 rounded-3xl border border-slate-800 shadow-2xl">
                @csrf
                <div>
                    <label class="block text-xs uppercase font-bold text-slate-400 mb-2">Full Name</label>
                    <input type="text" name="name" required placeholder="John Doe" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3.5 text-sm text-white placeholder-slate-600 focus:outline-none focus:border-brand-orange focus:ring-1 focus:ring-brand-orange transition duration-200">
                </div>
                <div>
                    <label class="block text-xs uppercase font-bold text-slate-400 mb-2">Phone Number</label>
                    <input type="tel" name="phone" required placeholder="(555) 019-2831" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3.5 text-sm text-white placeholder-slate-600 focus:outline-none focus:border-brand-orange focus:ring-1 focus:ring-brand-orange transition duration-200">
                </div>
                <div>
                    <label class="block text-xs uppercase font-bold text-slate-400 mb-2">Reservation Date</label>
                    <input type="date" name="date" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3.5 text-sm text-white focus:outline-none focus:border-brand-orange focus:ring-1 focus:ring-brand-orange transition duration-200">
                </div>
                <div>
                    <label class="block text-xs uppercase font-bold text-slate-400 mb-2">Time Slot</label>
                    <select name="time" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3.5 text-sm text-white focus:outline-none focus:border-brand-orange focus:ring-1 focus:ring-brand-orange transition duration-200">
                        <option value="">Select Preferred Time</option>
                        <option value="17:00">5:00 PM</option>
                        <option value="18:00">6:00 PM</option>
                        <option value="19:00">7:00 PM</option>
                        <option value="20:00">8:00 PM</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs uppercase font-bold text-slate-400 mb-2">Guests</label>
                    <select name="guests" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3.5 text-sm text-white focus:outline-none focus:border-brand-orange focus:ring-1 focus:ring-brand-orange transition duration-200">
                        <option value="2">2 People</option>
                        <option value="4">4 People</option>
                        <option value="6">6 People</option>
                        <option value="8">8+ People (Large Party)</option>
                    </select>
                </div>
                <div class="md:col-span-2 mt-4">
                    <button type="submit" class="w-full bg-gradient-to-r from-brand-orange to-amber-600 hover:from-brand-orangeHover hover:to-amber-700 text-white font-bold py-4 rounded-xl shadow-xl transition-all duration-300 uppercase text-xs tracking-wider transform hover:-translate-y-0.5 hover:scale-[1.01] active:translate-y-0">
                        Confirm Reservation Request
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection