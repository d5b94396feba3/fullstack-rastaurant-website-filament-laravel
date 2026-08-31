<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $settings['site_name'] ?? 'FLAVOR HARBOR' }} | {{ $settings['site_tagline'] ?? 'Artisanal Dining & Culinary Excellence' }}</title>
    <meta name="description" content="{{ $settings['site_description'] ?? 'Experience chef-crafted artisanal pastas, seasonal ingredients, and fine dining.' }}">

    @if(!empty($settings['favicon']))
        <link rel="icon" href="{{ Str::startsWith($settings['favicon'], 'http') ? $settings['favicon'] : asset('storage/' . $settings['favicon']) }}">
    @endif

    <!-- Fonts & Alpine.js / Tailwind CDN -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        serif: ['"Playfair Display"', 'serif'],
                    },
                    colors: {
                        brand: {
                            orange: '#F97316',
                            orangeHover: '#EA580C',
                            dark: '#0B0F17',
                            darkCard: '#111827',
                            lightBg: '#FAFAFA',
                            accentGold: '#D97706'
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-brand-lightBg text-slate-800 font-sans antialiased selection:bg-brand-orange selection:text-white" 
      x-data="{ 
          mobileOpen: false, 
          activeTab: 'all',
          cartOpen: false,
          cart: [],
          addToCart(item) {
              let found = this.cart.find(i => i.id === item.id);
              if (found) {
                  found.qty++;
              } else {
                  this.cart.push({ ...item, qty: 1 });
              }
              this.cartOpen = true;
          },
          get cartTotal() {
              return this.cart.reduce((sum, item) => sum + (item.price * item.qty), 0).toFixed(2);
          },
          get cartCount() {
              return this.cart.reduce((sum, item) => sum + item.qty, 0);
          }
      }">

    <!-- Dynamic Top Announcement Bar -->
    @if(!empty($settings['announcement_text']))
        <div class="bg-gradient-to-r from-amber-600 via-brand-orange to-amber-600 text-white text-xs font-bold py-2.5 px-4 text-center tracking-wider shadow-inner uppercase flex items-center justify-center gap-2">
            <span class="inline-block w-2 h-2 rounded-full bg-white animate-pulse"></span>
            {{ $settings['announcement_text'] }}
        </div>
    @endif

    <!-- Header Navigation -->
    <header class="bg-slate-950/90 backdrop-blur-md text-white sticky top-0 z-40 border-b border-slate-800/80 shadow-2xl transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="/" class="flex items-center gap-3.5 group">
                <div class="w-11 h-11 bg-gradient-to-br from-amber-500 via-brand-orange to-orange-700 rounded-2xl flex items-center justify-center text-white font-black text-2xl shadow-lg shadow-brand-orange/20 transition transform group-hover:scale-105 border border-white/10">
                    {{ $settings['logo_icon'] ?? '🍷' }}
                </div>
                <div>
                    <span class="font-extrabold text-2xl tracking-tight text-white block leading-none font-serif group-hover:text-amber-400 transition">{{ $settings['site_name'] ?? 'FLAVOR HARBOR' }}</span>
                    <span class="text-[10px] uppercase font-extrabold tracking-[0.2em] text-amber-500/90 block mt-1">{{ $settings['header_subtext'] ?? 'Fine Dining & Kitchen' }}</span>
                </div>
            </a>

            <nav class="hidden md:flex items-center space-x-8 font-semibold text-xs uppercase tracking-wider text-slate-300">
                <a href="#home" class="hover:text-brand-orange transition-colors duration-200">Home</a>
                <a href="#menu" class="hover:text-brand-orange transition-colors duration-200">Menu</a>
                <a href="#about" class="hover:text-brand-orange transition-colors duration-200">Our Story</a>
                <a href="#reserve" class="hover:text-brand-orange transition-colors duration-200">Reservations</a>
                <a href="#hours" class="hover:text-brand-orange transition-colors duration-200">Hours & Location</a>

                @php $navPages = \App\Models\Page::all(); @endphp
                @if(isset($navPages) && count($navPages) > 0)
                    @foreach($navPages as $page)
                        <a href="/page/{{ $page->slug }}" class="hover:text-brand-orange transition-colors duration-200">{{ $page->title }}</a>
                    @endforeach
                @endif
            </nav>

            <div class="flex items-center gap-5">
                <button @click="cartOpen = true" class="relative p-2.5 text-slate-300 hover:text-white transition rounded-full hover:bg-slate-800/60" aria-label="Shopping Cart">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <span x-show="cartCount > 0" x-text="cartCount" class="absolute top-0 right-0 bg-brand-orange text-white text-[10px] font-black w-5 h-5 rounded-full flex items-center justify-center shadow-lg border-2 border-slate-950"></span>
                </button>

                <a href="#reserve" class="hidden sm:inline-flex items-center gap-2 bg-gradient-to-r from-brand-orange to-amber-600 hover:from-brand-orangeHover hover:to-amber-700 text-white font-bold px-6 py-2.5 rounded-full shadow-lg shadow-brand-orange/20 text-xs uppercase tracking-wider transition transform hover:-translate-y-0.5 active:translate-y-0">
                    <span>Reserve Table</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>

                <button @click="mobileOpen = !mobileOpen" class="md:hidden text-slate-300 hover:text-white focus:outline-none p-1">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                        <path x-show="mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" style="display:none;"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Dynamic Mobile Menu Dropdown -->
        <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;" class="md:hidden bg-slate-950 border-b border-slate-800 px-6 py-6 space-y-4 font-semibold text-center text-slate-300 text-sm shadow-2xl">
            <a href="#home" @click="mobileOpen = false" class="block py-2 text-white hover:text-brand-orange transition">Home</a>
            <a href="#menu" @click="mobileOpen = false" class="block py-2 hover:text-brand-orange transition">Menu</a>
            <a href="#about" @click="mobileOpen = false" class="block py-2 hover:text-brand-orange transition">Our Story</a>
            <a href="#reserve" @click="mobileOpen = false" class="block py-2 hover:text-brand-orange transition">Reservations</a>
            <a href="#hours" @click="mobileOpen = false" class="block py-2 hover:text-brand-orange transition">Hours & Location</a>
            @if(isset($navPages) && count($navPages) > 0)
                @foreach($navPages as $page)
                    <a href="/page/{{ $page->slug }}" @click="mobileOpen = false" class="block py-2 hover:text-brand-orange transition">{{ $page->title }}</a>
                @endforeach
            @endif
            <a href="#reserve" @click="mobileOpen = false" class="block bg-brand-orange text-white font-bold py-3 rounded-full mt-4 text-xs uppercase tracking-wider shadow-lg">Reserve Table</a>
        </div>
    </header>

    <!-- Slide-over Cart Drawer -->
    <div x-show="cartOpen" class="relative z-50" style="display: none;">
        <div class="fixed inset-0 bg-black/75 backdrop-blur-sm transition-opacity" @click="cartOpen = false"></div>
        <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
            <div class="w-screen max-w-md bg-slate-900 text-slate-100 shadow-2xl flex flex-col border-l border-slate-800">
                <div class="p-6 bg-slate-950 text-white flex items-center justify-between border-b border-slate-800">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        <h2 class="text-lg font-extrabold font-serif">Your Order Selection</h2>
                    </div>
                    <button @click="cartOpen = false" class="text-slate-400 hover:text-white text-2xl font-light">&times;</button>
                </div>
                <div class="flex-1 overflow-y-auto p-6 space-y-4">
                    <template x-if="cart.length === 0">
                        <div class="text-center py-16 text-slate-500">
                            <svg class="w-12 h-12 mx-auto mb-3 text-slate-600 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                            <p class="text-sm font-medium">Your order tray is currently empty.</p>
                            <p class="text-xs text-slate-600 mt-1">Explore our culinary items and add them here.</p>
                        </div>
                    </template>
                    <template x-for="item in cart" :key="item.id">
                        <div class="flex justify-between items-center border-b border-slate-800 pb-4">
                            <div>
                                <h5 class="font-bold text-white text-sm" x-text="item.name"></h5>
                                <p class="text-xs text-slate-400 mt-0.5" x-text="'$' + item.price.toFixed(2) + ' × ' + item.qty"></p>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="font-black text-sm text-brand-orange" x-text="'$' + (item.price * item.qty).toFixed(2)"></span>
                            </div>
                        </div>
                    </template>
                </div>
                <div class="p-6 border-t border-slate-800 bg-slate-950">
                    <div class="flex justify-between font-bold text-white text-base mb-6">
                        <span>Subtotal:</span>
                        <span class="text-brand-orange text-lg" x-text="'$' + cartTotal"></span>
                    </div>
                    <form action="{{ Route::has('checkout') ? route('checkout') : '/checkout' }}" method="POST">
                        @csrf
                        <input type="hidden" name="cart_data" :value="JSON.stringify(cart)">
                        <button type="submit" :disabled="cart.length === 0" :class="cart.length === 0 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-brand-orangeHover'" class="w-full bg-brand-orange text-white font-bold py-3.5 rounded-xl uppercase text-xs tracking-wider transition shadow-lg shadow-brand-orange/20">
                            Proceed to Secure Checkout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Dynamic Hero Section -->
    <section id="home" class="relative bg-slate-950 text-white min-h-[680px] lg:min-h-[780px] flex items-center overflow-hidden border-b border-slate-900">
        <div class="absolute inset-0 bg-cover bg-center z-0 scale-105 transform transition duration-1000" style="background-image: url('{{ $settings['hero_image'] ?? 'https://images.unsplash.com/photo-1551183053-bf91a1d81141?auto=format&fit=crop&w=1920&q=80' }}')"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-950/85 to-transparent z-10"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent to-slate-950/50 z-10"></div>

        <div class="relative z-20 max-w-7xl mx-auto px-6 py-24 w-full">
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-slate-900/80 border border-amber-500/30 text-amber-400 font-bold uppercase tracking-widest text-[11px] mb-6 backdrop-blur-md">
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
                    <a href="#reserve" class="bg-gradient-to-r from-brand-orange to-amber-600 hover:from-brand-orangeHover hover:to-amber-700 text-white font-bold px-8 py-4 rounded-full text-xs uppercase tracking-wider transition shadow-2xl shadow-brand-orange/30 transform hover:-translate-y-0.5">
                        Reserve Table
                    </a>
                    <a href="#menu" class="border border-white/20 hover:border-white text-white hover:bg-white/10 font-bold px-8 py-4 rounded-full text-xs uppercase tracking-wider transition bg-slate-900/40 backdrop-blur-md shadow-lg">
                        Explore Menu
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Key Highlights / Micro Features Bar -->
    <section class="bg-slate-900 border-b border-slate-800 text-slate-300 py-6 text-xs font-semibold">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div class="flex items-center justify-center gap-3">
                <span class="text-xl">🌿</span>
                <span class="uppercase tracking-wider">100% Organic Produce</span>
            </div>
            <div class="flex items-center justify-center gap-3">
                <span class="text-xl">🍝</span>
                <span class="uppercase tracking-wider">Fresh Daily Dough</span>
            </div>
            <div class="flex items-center justify-center gap-3">
                <span class="text-xl">🍷</span>
                <span class="uppercase tracking-wider">Sommelier Selection</span>
            </div>
            <div class="flex items-center justify-center gap-3">
                <span class="text-xl">⭐</span>
                <span class="uppercase tracking-wider">Top Rated Dining</span>
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
                    :class="activeTab === 'all' ? 'bg-slate-900 text-white ring-2 ring-slate-900' : 'bg-white text-slate-600 border border-slate-200 hover:border-slate-400 hover:text-slate-900'"
                    class="px-6 py-2.5 rounded-full font-bold text-xs uppercase tracking-wider transition-all duration-200 shadow-sm">
                All Specialties
            </button>

            @if(isset($categories) && count($categories) > 0)
                @foreach($categories as $category)
                    <button @click="activeTab = 'cat-{{ $category->id }}'" 
                            :class="activeTab === 'cat-{{ $category->id }}' ? 'bg-slate-900 text-white ring-2 ring-slate-900' : 'bg-white text-slate-600 border border-slate-200 hover:border-slate-400 hover:text-slate-900'"
                            class="px-6 py-2.5 rounded-full font-bold text-xs uppercase tracking-wider transition-all duration-200 shadow-sm">
                        {{ $category->name }}
                    </button>
                @endforeach
            @endif
        </div>

        <!-- Dynamic Menu Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Executive Story Highlight Card -->
            <div class="bg-gradient-to-b from-slate-900 to-slate-950 rounded-2xl overflow-hidden shadow-2xl flex flex-col justify-between text-white border border-slate-800 hover:border-amber-500/40 transition duration-300">
                <div class="h-60 overflow-hidden relative">
                    <img src="{{ $settings['story_image'] ?? 'https://images.unsplash.com/photo-1577219491135-ce391730fb2c?auto=format&fit=crop&w=600&q=80' }}" alt="Executive Chef" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <span class="text-amber-400 font-bold text-[10px] uppercase tracking-widest block mb-1">{{ $settings['story_role'] ?? 'Executive Chef' }}</span>
                        <h3 class="text-2xl font-bold font-serif mb-2 text-white">{{ $settings['story_title'] ?? 'Artisanal Tradition' }}</h3>
                        <p class="text-xs text-slate-400 leading-relaxed mb-6">{{ $settings['story_description'] ?? 'Every plate is curated with wild-caught seafood and house-rolled dough crafted every morning.' }}</p>
                    </div>
                    <a href="#about" class="text-brand-orange text-xs font-bold uppercase tracking-wider inline-flex items-center gap-2 hover:translate-x-1 transition duration-200">
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
                            <div class="bg-white rounded-2xl overflow-hidden border border-slate-200/80 shadow-sm hover:shadow-2xl transition-all duration-300 flex flex-col justify-between group" 
                                 x-show="activeTab === 'all' || activeTab === 'cat-{{ $category->id }}'" x-transition>
                                <div>
                                    <div class="h-60 bg-slate-100 overflow-hidden relative">
                                        @if(!empty($item->image))
                                            <img src="{{ Str::startsWith($item->image, 'http') ? $item->image : asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-slate-100 text-slate-400 text-xs font-bold uppercase tracking-wider">Image Coming Soon</div>
                                        @endif
                                        <div class="absolute top-3 right-3 bg-slate-950/90 backdrop-blur-md text-amber-400 font-black text-xs px-3.5 py-1.5 rounded-full border border-amber-500/20 shadow-lg">
                                            ${{ number_format($item->price, 2) }}
                                        </div>
                                    </div>
                                    <div class="p-6">
                                        <h4 class="font-bold text-slate-900 text-lg mb-2 font-serif leading-snug group-hover:text-brand-orange transition">{{ $item->name }}</h4>
                                        <p class="text-xs text-slate-500 leading-relaxed mb-4 line-clamp-3 font-normal">{{ $item->description }}</p>
                                    </div>
                                </div>
                                <div class="px-6 pb-6">
                                    <button @click="addToCart({ id: {{ $item->id }}, name: '{{ addslashes($item->name) }}', price: {{ $item->price }} })"
                                            class="w-full bg-slate-900 hover:bg-brand-orange text-white font-bold py-3 rounded-xl text-xs uppercase tracking-wider transition-colors duration-200 shadow-md">
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
                    <a href="{{ $settings['doordash_url'] }}" target="_blank" class="bg-red-600 hover:bg-red-700 text-white font-bold px-8 py-4 rounded-full text-xs uppercase tracking-wider shadow-lg transition transform hover:-translate-y-0.5">
                        Order via DoorDash
                    </a>
                @endif
                @if(!empty($settings['ubereats_url']))
                    <a href="{{ $settings['ubereats_url'] }}" target="_blank" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-8 py-4 rounded-full text-xs uppercase tracking-wider shadow-lg transition transform hover:-translate-y-0.5">
                        Order via Uber Eats
                    </a>
                @endif
                @if(!empty($settings['grubhub_url']))
                    <a href="{{ $settings['grubhub_url'] }}" target="_blank" class="bg-orange-500 hover:bg-orange-600 text-white font-bold px-8 py-4 rounded-full text-xs uppercase tracking-wider shadow-lg transition transform hover:-translate-y-0.5">
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
                <img src="{{ $settings['about_image_1'] ?? 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=800&q=80' }}" alt="Dining Room" class="rounded-2xl shadow-xl h-80 w-full object-cover">
                <img src="{{ $settings['about_image_2'] ?? 'https://images.unsplash.com/photo-1550966871-3ed3cdb5ed0c?auto=format&fit=crop&w=800&q=80' }}" alt="Restaurant Atmosphere" class="rounded-2xl shadow-xl h-80 w-full object-cover mt-10">
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
                    <div>
                        <div class="text-3xl font-black text-slate-900 font-serif text-brand-orange">{{ $settings['stat_1_val'] ?? '100%' }}</div>
                        <div class="text-[11px] text-slate-500 font-bold uppercase tracking-wider mt-1">{{ $settings['stat_1_lbl'] ?? 'Fresh Ingredients' }}</div>
                    </div>
                    <div>
                        <div class="text-3xl font-black text-slate-900 font-serif text-brand-orange">{{ $settings['stat_2_val'] ?? '15+' }}</div>
                        <div class="text-[11px] text-slate-500 font-bold uppercase tracking-wider mt-1">{{ $settings['stat_2_lbl'] ?? 'Years Excellence' }}</div>
                    </div>
                    <div>
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
                <div class="bg-slate-950 p-8 rounded-2xl border border-slate-800 shadow-xl">
                    <div class="flex text-amber-400 mb-4 text-sm">★★★★★</div>
                    <p class="text-slate-300 text-sm leading-relaxed mb-6 font-normal">"The wild-caught seafood pasta was absolutely divine. The atmosphere hits the perfect balance between modern elegance and cozy warmth."</p>
                    <div class="font-bold text-sm text-white font-serif">— Elena Rostova</div>
                    <div class="text-xs text-slate-500">Verified Diner</div>
                </div>
                <div class="bg-slate-950 p-8 rounded-2xl border border-slate-800 shadow-xl">
                    <div class="flex text-amber-400 mb-4 text-sm">★★★★★</div>
                    <p class="text-slate-300 text-sm leading-relaxed mb-6 font-normal">"Without a doubt the finest dining experience in the area. Reservation process was smooth, and the wine pairings were spot on."</p>
                    <div class="font-bold text-sm text-white font-serif">— Marcus Vance</div>
                    <div class="text-xs text-slate-500">Food & Wine Critic</div>
                </div>
                <div class="bg-slate-950 p-8 rounded-2xl border border-slate-800 shadow-xl">
                    <div class="flex text-amber-400 mb-4 text-sm">★★★★★</div>
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
                <div class="space-y-4 text-sm text-slate-600 bg-white p-8 rounded-2xl shadow-sm border border-slate-200">
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
                <div class="mt-8 text-sm bg-slate-900 text-white p-8 rounded-2xl shadow-lg border border-slate-800">
                    <p class="font-bold text-white text-base font-serif mb-1">{{ $settings['site_name'] ?? 'Flavor Harbor Restaurant' }}</p>
                    <p class="text-slate-300 leading-relaxed">{{ $settings['address_line_1'] ?? '124 Harbor View Boulevard, Suite 100' }}</p>
                    <p class="text-slate-300 leading-relaxed">{{ $settings['address_line_2'] ?? 'Coastal City, CA 90210' }}</p>
                </div>
            </div>
            <div class="bg-slate-300 rounded-2xl h-96 overflow-hidden shadow-xl border border-slate-300 relative">
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
                    <input type="text" name="name" required placeholder="John Doe" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3.5 text-sm text-white placeholder-slate-600 focus:outline-none focus:border-brand-orange focus:ring-1 focus:ring-brand-orange">
                </div>
                <div>
                    <label class="block text-xs uppercase font-bold text-slate-400 mb-2">Phone Number</label>
                    <input type="tel" name="phone" required placeholder="(555) 019-2831" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3.5 text-sm text-white placeholder-slate-600 focus:outline-none focus:border-brand-orange focus:ring-1 focus:ring-brand-orange">
                </div>
                <div>
                    <label class="block text-xs uppercase font-bold text-slate-400 mb-2">Reservation Date</label>
                    <input type="date" name="date" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3.5 text-sm text-white focus:outline-none focus:border-brand-orange focus:ring-1 focus:ring-brand-orange">
                </div>
                <div>
                    <label class="block text-xs uppercase font-bold text-slate-400 mb-2">Time Slot</label>
                    <select name="time" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3.5 text-sm text-white focus:outline-none focus:border-brand-orange focus:ring-1 focus:ring-brand-orange">
                        <option value="">Select Preferred Time</option>
                        <option value="17:00">5:00 PM</option>
                        <option value="18:00">6:00 PM</option>
                        <option value="19:00">7:00 PM</option>
                        <option value="20:00">8:00 PM</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs uppercase font-bold text-slate-400 mb-2">Guests</label>
                    <select name="guests" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3.5 text-sm text-white focus:outline-none focus:border-brand-orange focus:ring-1 focus:ring-brand-orange">
                        <option value="2">2 People</option>
                        <option value="4">4 People</option>
                        <option value="6">6 People</option>
                        <option value="8">8+ People (Large Party)</option>
                    </select>
                </div>
                <div class="md:col-span-2 mt-4">
                    <button type="submit" class="w-full bg-gradient-to-r from-brand-orange to-amber-600 hover:from-brand-orangeHover hover:to-amber-700 text-white font-bold py-4 rounded-xl shadow-xl transition uppercase text-xs tracking-wider">
                        Confirm Reservation Request
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-950 text-slate-400 py-16 text-xs border-t border-slate-900">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
            <div class="md:col-span-2">
                <span class="font-extrabold text-white text-xl font-serif block mb-3">{{ $settings['site_name'] ?? 'FLAVOR HARBOR' }}</span>
                <p class="text-slate-400 text-xs leading-relaxed max-w-sm mb-4">{{ $settings['site_description'] ?? 'Experience chef-crafted artisanal pastas, seasonal ingredients, and fine dining.' }}</p>
                <p class="text-slate-500 text-[11px]">&copy; {{ date('Y') }} {{ $settings['site_name'] ?? 'Flavor Harbor Restaurant' }}. All Rights Reserved.</p>
            </div>
            <div>
                <h5 class="font-bold text-white text-xs uppercase tracking-wider mb-4">Navigation</h5>
                <ul class="space-y-2.5">
                    <li><a href="#home" class="hover:text-white transition">Home</a></li>
                    <li><a href="#menu" class="hover:text-white transition">Menu</a></li>
                    <li><a href="#about" class="hover:text-white transition">Our Story</a></li>
                    <li><a href="#reserve" class="hover:text-white transition">Reservations</a></li>
                    <li><a href="#hours" class="hover:text-white transition">Hours & Location</a></li>
                </ul>
            </div>
            <div>
                <h5 class="font-bold text-white text-xs uppercase tracking-wider mb-4">Pages</h5>
                <ul class="space-y-2.5">
                    @if(isset($navPages) && count($navPages) > 0)
                        @foreach($navPages as $page)
                            <li><a href="/page/{{ $page->slug }}" class="hover:text-white transition">{{ $page->title }}</a></li>
                        @endforeach
                    @else
                        <li class="text-slate-600">No additional pages</li>
                    @endif
                </ul>
            </div>
        </div>
    </footer>

</body>
</html>