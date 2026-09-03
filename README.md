# Flavor Harbor — Restaurant Website (Laravel + Filament)

A full-stack restaurant website for **FLAVOR HARBOR**: a public-facing dining site with menu browsing, cart checkout, and table reservations, plus a Filament admin panel for kitchen menu and CMS content.

## Stack

| Layer | Technology |
| --- | --- |
| Backend | [Laravel](https://laravel.com) 13 (PHP 8.3+) |
| Admin | [Filament](https://filamentphp.com) 3 panel at `/admin` |
| Frontend | Blade, Alpine.js, [Vite](https://vitejs.dev) 8, [Tailwind CSS](https://tailwindcss.com) 4 |
| Database | MySQL (configurable via `.env`) |

### Laravel

Laravel powers routing, Eloquent models, migrations, authentication for the admin panel, file storage for menu images, and the public site views. Core domain models:

- **Category** — menu sections (active/inactive)
- **MenuItem** — dishes with price, image, description, availability
- **Page** — CMS pages with slug, rich content, and SEO fields
- **Setting** — key/value site configuration (branding, hero, contact, social links)

### Filament

Filament provides the **Kitchen Ops** admin UI (`FLAVOR HARBOR | Kitchen Ops`) at `/admin` with:

- **Kitchen Menu**
  - Categories (name, slug, active status)
  - Menu items (category, price, image upload, availability)
- **System Configuration**
  - CMS pages (rich editor + SEO: meta title, description, OG image)
  - Site settings (logo, hero, contact, social URLs, and related keys)
- **Dashboard widget** — totals for menu items, categories, and CMS pages

Admin access uses Filament’s built-in login and Laravel’s `User` model.

## Features

**Public site**

- Dynamic homepage driven by settings and active menu categories
- Menu listing with available items only
- Client-side cart and checkout form (`POST /checkout`)
- Reservation request form (`POST /reserve`)
- Dynamic CMS pages via slug (`/{slug}`)
- Branding, hours, and contact info from settings

**Admin (`/admin`)**

- CRUD for categories, menu items, pages, and settings
- Image uploads for menu items and SEO assets
- Orange-themed Filament panel branded for restaurant operations

## Requirements

- PHP 8.3+
- Composer
- Node.js & npm
- MySQL (or another DB supported by Laravel)

## Installation

```bash
git clone https://github.com/d5b94396feba3/fullstack-rastaurant-website-filament-laravel.git
cd fullstack-rastaurant-website-filament-laravel

composer install
cp .env.example .env
php artisan key:generate
```

Configure the database in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Then migrate, link storage, and build assets:

```bash
php artisan migrate
php artisan storage:link
npm install
npm run build
```

Optional sample restaurant data (categories, menu items, pages, settings):

```bash
php artisan db:seed --class=RestaurantSeeder
```

Create an admin user (Filament login), for example:

```bash
php artisan make:filament-user
```

Or seed the default test user from `DatabaseSeeder` (`test@example.com`) and set a known password as needed.

### Terminal-free setup (optional)

With the app already configured and reachable, visiting `/system-setup-run` runs migrations, clears caches, and creates the public storage symlink. Prefer the Artisan commands above in local development.

## Running locally

```bash
php artisan serve
```

Or the Composer dev script (if configured for concurrent Vite + server):

```bash
composer run dev
```

| URL | Purpose |
| --- | --- |
| `http://localhost:8000` | Public restaurant site |
| `http://localhost:8000/admin` | Filament admin panel |
| `http://localhost:8000/home` | Alternate home route |
| `http://localhost:8000/{slug}` | CMS page (e.g. `/our-story`) |

## Project structure (high level)

```
app/
  Filament/Resources/   # Category, MenuItem, Page, Setting resources
  Filament/Widgets/     # Restaurant stats overview
  Models/               # Eloquent models
  Providers/Filament/   # Admin panel provider (path, brand, colors)
resources/views/        # Public Blade templates (index, layout, CMS page)
routes/web.php          # Public routes + setup helper
database/migrations/    # users, categories, menu_items, pages, settings
database/seeders/       # RestaurantSeeder, SettingSeeder
```

## Useful Artisan commands

```bash
php artisan migrate
php artisan db:seed --class=RestaurantSeeder
php artisan make:filament-user
php artisan storage:link
php artisan filament:upgrade
```

## License

This project is open-sourced under the [MIT license](LICENSE).

Laravel is a trademark of Laravel Holdings Inc. Filament is a product of Filament. See their respective documentation for framework details:

- [Laravel docs](https://laravel.com/docs)
- [Filament docs](https://filamentphp.com/docs)
