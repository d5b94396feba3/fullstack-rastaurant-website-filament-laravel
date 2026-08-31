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

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> -->

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

    <style>
        /* Scroll Reveal Animation Styles */
        .reveal-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }
        .reveal-on-scroll.is-revealed {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="bg-brand-lightBg text-slate-800 font-sans antialiased selection:bg-brand-orange selection:text-white" 
      x-data="{ 
          mobileOpen: false, 
          activeTab: 'all',
          cartOpen: false,
          cart: [],
          addToCart(item) {
              let found = this.cart.find(i => i.id === item.id);
              if (found) { found.qty++; } else { this.cart.push({ ...item, qty: 1 }); }
              this.cartOpen = true;
          },
          get cartTotal() { return this.cart.reduce((sum, item) => sum + (item.price * item.qty), 0).toFixed(2); },
          get cartCount() { return this.cart.reduce((sum, item) => sum + item.qty, 0); }
      }">

    @if(!empty($settings['announcement_text']))
        <div class="bg-gradient-to-r from-amber-600 via-brand-orange to-amber-600 text-white text-xs font-bold py-2.5 px-4 text-center tracking-wider shadow-inner uppercase flex items-center justify-center gap-2">
            <span class="inline-block w-2 h-2 rounded-full bg-white animate-pulse"></span>
            {{ $settings['announcement_text'] }}
        </div>
    @endif

    <header class="bg-slate-950/90 backdrop-blur-md text-white sticky top-0 z-40 border-b border-slate-800/80 shadow-2xl transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="/" class="flex items-center gap-3.5 group">
                @if(!empty($settings['logo_image']))
                    <img src="{{ Str::startsWith($settings['logo_image'], 'http') ? $settings['logo_image'] : asset('storage/' . $settings['logo_image']) }}" alt="Logo" class="h-11 w-auto rounded-xl object-contain">
                @else
                    <div class="w-11 h-11 bg-gradient-to-br from-amber-500 via-brand-orange to-orange-700 rounded-2xl flex items-center justify-center text-white font-black text-2xl shadow-lg border border-white/10">
                        {{ $settings['logo_icon'] ?? '🍷' }}
                    </div>
                @endif
                <div>
                    <span class="font-extrabold text-2xl tracking-tight text-white block leading-none font-serif">{{ $settings['site_name'] ?? 'FLAVOR HARBOR' }}</span>
                    <span class="text-[10px] uppercase font-extrabold tracking-[0.2em] text-amber-500/90 block mt-1">{{ $settings['header_subtext'] ?? 'Fine Dining & Kitchen' }}</span>
                </div>
            </a>

            <nav class="hidden md:flex items-center space-x-8 font-semibold text-xs uppercase tracking-wider text-slate-300">
                @php $navPages = \App\Models\Page::all(); @endphp
                @if(isset($navPages) && count($navPages) > 0)
                    @foreach($navPages as $p)
                        <a href="/{{ $p->slug }}" class="hover:text-brand-orange transition {{ Request::is($p->slug) ? 'text-brand-orange font-bold' : '' }}">{{ $p->title }}</a>
                    @endforeach
                @endif
            </nav>

            <div class="flex items-center gap-5">
                <button @click="cartOpen = true" class="relative p-2.5 text-slate-300 hover:text-white transition rounded-full hover:bg-slate-800/60" aria-label="Shopping Cart">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    <span x-show="cartCount > 0" x-text="cartCount" class="absolute top-0 right-0 bg-brand-orange text-white text-[10px] font-black w-5 h-5 rounded-full flex items-center justify-center shadow-lg border-2 border-slate-950"></span>
                </button>
                <a href="/#reserve" class="hidden sm:inline-flex items-center gap-2 bg-gradient-to-r from-brand-orange to-amber-600 hover:from-brand-orangeHover hover:to-amber-700 text-white font-bold px-6 py-2.5 rounded-full shadow-lg text-xs uppercase tracking-wider transition">
                    <span>Reserve Table</span>
                </a>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <!-- Professional Fully Dynamic Footer -->
    <footer class="bg-slate-950 text-slate-400 py-20 text-xs border-t border-slate-900">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 mb-16">
            
            <!-- Col 1: Brand, Logo & Social Media Icons -->
            <div class="space-y-4">
                <a href="/" class="flex items-center gap-3.5 group">
                    @if(!empty($settings['logo_image']))
                        <img src="{{ Str::startsWith($settings['logo_image'], 'http') ? $settings['logo_image'] : asset('storage/' . $settings['logo_image']) }}" alt="Logo" class="h-10 w-auto rounded-xl object-contain">
                    @else
                        <div class="w-10 h-10 bg-gradient-to-br from-amber-500 via-brand-orange to-orange-700 rounded-xl flex items-center justify-center text-white font-black text-xl shadow-lg border border-white/10">
                            {{ $settings['logo_icon'] ?? '🍷' }}
                        </div>
                    @endif
                    <div>
                        <span class="font-extrabold text-white text-base tracking-tight font-serif block leading-none">{{ $settings['site_name'] ?? 'FLAVOR HARBOR' }}</span>
                        <span class="text-[9px] uppercase font-extrabold tracking-[0.2em] text-amber-500/90 block mt-0.5">{{ $settings['header_subtext'] ?? 'Fine Dining & Kitchen' }}</span>
                    </div>
                </a>
                <p class="text-slate-400 text-xs leading-relaxed">
                    {{ $settings['site_description'] ?? 'Experience chef-crafted artisanal pastas and Mediterranean fine dining.' }}
                </p>
                <!-- SVG Social Media Icons -->
                <div class="flex items-center gap-3 pt-2">
                    <a href="{{ $settings['social_facebook'] ?? 'https://facebook.com' }}" target="_blank" class="w-8 h-8 rounded-full bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-300 hover:bg-brand-orange hover:text-white transition" aria-label="Facebook">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="{{ $settings['social_instagram'] ?? 'https://instagram.com' }}" target="_blank" class="w-8 h-8 rounded-full bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-300 hover:bg-brand-orange hover:text-white transition" aria-label="Instagram">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                    <a href="{{ $settings['social_twitter'] ?? 'https://twitter.com' }}" target="_blank" class="w-8 h-8 rounded-full bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-300 hover:bg-brand-orange hover:text-white transition" aria-label="Twitter">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                </div>
            </div>

            <!-- Col 2: Site Sections & Menu Links -->
            <div>
                <h5 class="font-bold text-white text-xs uppercase tracking-wider mb-4 border-l-2 border-brand-orange pl-3"> Links</h5>
                <ul class="space-y-2.5">
                    <li><a href="/#home" class="hover:text-white transition">Home</a></li>
                    <li><a href="/#menu" class="hover:text-white transition">Chef Specials</a></li>
                    <li><a href="/#about" class="hover:text-white transition">Our Heritage Story</a></li>
                    <li><a href="/#order" class="hover:text-white transition">Online Delivery</a></li>
                    <li><a href="/#reserve" class="hover:text-white transition">Table Booking</a></li>
                </ul>
            </div>

            <!-- Col 3: Business Hours -->
            <div>
                <h5 class="font-bold text-white text-xs uppercase tracking-wider mb-4 border-l-2 border-brand-orange pl-3">Dining Hours</h5>
                <ul class="space-y-2 text-slate-400">
                    <li class="flex justify-between border-b border-slate-900 pb-1">
                        <span>Mon – Thu:</span>
                        <span class="text-slate-300 font-medium">{{ $settings['hours_weekday'] ?? '11:30 AM – 10:00 PM' }}</span>
                    </li>
                    <li class="flex justify-between border-b border-slate-900 pb-1">
                        <span>Fri – Sat:</span>
                        <span class="text-amber-400 font-semibold">{{ $settings['hours_weekend'] ?? '11:30 AM – 11:00 PM' }}</span>
                    </li>
                    <li class="flex justify-between pb-1">
                        <span>Sunday:</span>
                        <span class="text-slate-300 font-medium">{{ $settings['hours_sunday'] ?? '10:30 AM – 9:00 PM' }}</span>
                    </li>
                </ul>
            </div>

            <!-- Col 4: Contact Information -->
            <div>
                <h5 class="font-bold text-white text-xs uppercase tracking-wider mb-4 border-l-2 border-brand-orange pl-3">Contact Info</h5>
                <ul class="space-y-2.5 text-slate-400">
                    <li class="flex items-start gap-2">
                        <span class="text-brand-orange font-bold">📍</span>
                        <span>{{ $settings['address_line_1'] ?? '124 Harbor View Blvd, Suite 100' }}</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-brand-orange font-bold">📞</span>
                        <span>{{ $settings['contact_phone'] ?? '(555) 382-9011' }}</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-brand-orange font-bold">✉️</span>
                        <span>{{ $settings['contact_email'] ?? 'concierge@flavorharbor.com' }}</span>
                    </li>
                </ul>
            </div>

            <!-- Col 5: Newsletter Subscription -->
            <div>
                <h5 class="font-bold text-white text-xs uppercase tracking-wider mb-4 border-l-2 border-brand-orange pl-3">Newsletter</h5>
                <p class="text-slate-400 text-xs mb-3 leading-relaxed">Get seasonal menu updates and special discount codes.</p>
                <form action="/newsletter-subscribe" method="POST" class="space-y-2">
                    @csrf
                    <input type="email" name="email" required placeholder="Your email address" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-3 py-2 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-brand-orange">
                    <button type="submit" class="w-full bg-brand-orange hover:bg-brand-orangeHover text-white font-bold py-2 rounded-xl uppercase text-[10px] tracking-wider transition shadow-md">
                        Subscribe
                    </button>
                </form>
            </div>

        </div>

        <!-- Bottom Sub-Footer Bar -->
        <div class="max-w-7xl mx-auto px-6 pt-8 border-t border-slate-900 flex flex-col sm:flex-row items-center justify-between gap-4 text-slate-500 text-[11px]">
            <p>&copy; {{ date('Y') }} {{ $settings['site_name'] ?? 'Flavor Harbor Restaurant' }}. All Rights Reserved.</p>
            <div class="flex items-center space-x-6 text-slate-400">
                @php $footerPages = \App\Models\Page::all(); @endphp
                @if(isset($footerPages) && count($footerPages) > 0)
                    @foreach($footerPages as $p)
                        <a href="/{{ $p->slug }}" class="hover:text-white transition">{{ $p->title }}</a>
                    @endforeach
                @endif
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.15
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-revealed');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('section').forEach(section => {
                section.classList.add('reveal-on-scroll');
                observer.observe(section);
            });
        });
    </script>
</body>
</html>