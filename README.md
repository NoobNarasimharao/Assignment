## Recycling Facility Directory

A clean, practical Laravel app for managing a directory of recycling facilities. It lets you add/edit/delete facilities, search and filter by materials, sort by last update, download the current view as CSV, and view a facility detail page with a Google Maps embed. Authentication is enabled so only logged-in users can access the directory.

### Stack
- Laravel 12 (PHP 8.2)
- MySQL
- Blade + Bootstrap 5
- Laravel Breeze (auth)

---
1) Requirements
- PHP 8.2+, Composer (for Laravel)
- Node Js (for Frontend Components)
- MySQL 

2) Setup
   First copy the example of env file to .env file
```bash
#First copy the example of env file to .env file
cp .env.example .env
php artisan key:generate

# In .env, set your DB connection

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=recycling_facility_directory
DB_USERNAME=your_user
DB_PASSWORD=your_password

#use composer install get the Dependencies and npm for installing dependencies and building the app

composer install
npm install
npm run build
php artisan migrate
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

