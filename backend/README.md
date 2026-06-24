# Full Stack E-Commerce System

Laravel powers the Blade admin panel and REST API. The customer-facing storefront is a Vue single-page interface mounted from `resources/views/store.blade.php` and calls the API with Axios.

## Included Features

- Blade admin login and dashboard
- Category CRUD
- Product CRUD with image upload or image URL
- Order list, details, and status updates
- User list
- Public catalog API with category, search, price, sort, and pagination filters
- Token-based auth API for register, login, logout, profile, and password changes
- Wishlist, cart, checkout, order history, and product reviews
- Seeded demo categories, products, admin account, and customer account

## Setup

```bash
composer install
npm install
php artisan migrate --seed
npm run build
php artisan serve
```

If uploaded product images should be publicly visible, run:

```bash
php artisan storage:link
```

## Demo Accounts

- Admin: `admin@example.com` / `password`
- Customer: `customer@example.com` / `password`

## Main Routes

- Storefront: `/`
- Admin login: `/admin/login`
- Admin dashboard: `/admin`

## API Endpoints

Public:

- `GET /api/categories`
- `GET /api/products`
- `GET /api/products/{product}`
- `POST /api/register`
- `POST /api/login`

Protected with `Authorization: Bearer {token}`:

- `POST /api/logout`
- `GET /api/profile`
- `PUT /api/profile`
- `PUT /api/profile/password`
- `GET /api/wishlist`
- `POST /api/wishlist`
- `DELETE /api/wishlist/{product}`
- `GET /api/cart`
- `POST /api/cart`
- `PUT /api/cart/{cartItem}`
- `DELETE /api/cart/{cartItem}`
- `POST /api/checkout`
- `GET /api/orders`
- `GET /api/orders/{order}`
- `POST /api/products/{product}/reviews`

The document asks for Sanctum. This environment could not download new Composer packages, so the project uses a local `api_tokens` table and Bearer-token middleware with the same frontend/API request flow.
