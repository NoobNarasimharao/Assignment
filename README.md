## Recycling Facility Directory

A clean, practical Laravel app for managing a directory of recycling facilities. It lets you add/edit/delete facilities, search and filter by materials, sort by last update, download the current view as CSV, and view a facility detail page with a Google Maps embed. Authentication is enabled so only logged-in users can access the directory.

### Stack
- Laravel 12 (PHP 8.2)
- MySQL
- Blade + Bootstrap 5
- Laravel Breeze (auth)

---

## Quick start

1) Requirements
- PHP 8.2+, Composer
- Node 18+
- MySQL 8+ (or MariaDB)

2) Setup
```bash
cp .env.example .env
php artisan key:generate

# In .env, set your DB connection
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=recycling_facility_directory
DB_USERNAME=your_user
DB_PASSWORD=your_password

composer install
npm install
npm run build
php artisan migrate
```

3) Run
```bash
php artisan serve
# → http://127.0.0.1:8000
```

4) Auth
- Breeze is installed. Visit `/register` to create an account or `/login` to sign in.
- All facility pages and CSV export are behind auth.

---

## What’s included

- Facilities CRUD (create, edit, delete)
- Index page with:
  - Search by business name, city, or material
  - Filter by material
  - Sort by last update (newest/oldest)
  - Pagination
  - CSV export of the current result set
- Facility detail page with full info and a Google Maps embed

---

## Database schema and relationships

Tables
- `facilities`
  - `id` (PK)
  - `business_name` string
  - `last_update_date` date
  - `street_address` string
  - `city` string
  - `state` string
  - `postal_code` string
  - timestamps
- `materials`
  - `id` (PK)
  - `name` string unique
  - timestamps
- `facility_material` (pivot)
  - `id`
  - `facility_id` FK → facilities.id (cascade)
  - `material_id` FK → materials.id (cascade)
  - timestamps

Eloquent
- `Facility` ↔ `Material`: many-to-many via `facility_material`
- `Facility::getFullAddressAttribute()` exposes a `full_address` string for display/export/maps

---

## How search, filter, sort, and export work

Controller: `app/Http/Controllers/FacilityController.php`
- Request params
  - `q`: search (business_name OR city OR material name using `whereHas`)
  - `material_id`: filter by material
  - `sort`: `updated_desc` | `updated_asc`
- Pagination: 10 per page, `withQueryString()` to keep filters while paging
- CSV export: reuses the same query builder as index and streams rows with headers:
  - Business Name, Last Updated, Address, Materials Accepted

---

## UI overview

Views (Blade)
- Layout for CRUD pages: `resources/views/layouts/main.blade.php`
- Index: `resources/views/facilities/index.blade.php`
- Create/Edit form (shared partial): `resources/views/facilities/_form.blade.php`
- Show (with Google Maps embed): `resources/views/facilities/show.blade.php`

Styling
- Bootstrap 5 for tables/forms (Paginator set to Bootstrap in `AppServiceProvider`)

Routes
- `GET /` → facilities index (auth)
- `resource('facilities', ...)`
- `GET /facilities-export` → CSV (auth)
- Breeze auth routes in `routes/auth.php`

---

## Development

Helpful commands
```bash
# install & build
composer install
npm install && npm run build

# env & key
cp .env.example .env && php artisan key:generate

# database
php artisan migrate

# serve
php artisan serve

# dev assets (hot reload)
npm run dev
```

Testing data
- The project includes seeders/migrations. If you want to reseed with your own data, create seeders and run `php artisan db:seed`. (The sample dataset has already been inserted as per the task.)

---

## Notes & possible improvements

- Add roles/permissions (e.g., admin-only CSV)
- Server-side column sorting for more fields
- Bulk import/export (CSV/Excel)
- Geocoding for addresses and map markers
- Feature tests with Pest

