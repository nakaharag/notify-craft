# Post-It App

A modern single-page application (SPA) built with Laravel, Inertia.js, Vue 3, and Pinia. This app allows authenticated users (including anonymous login) to create, view, filter, sort, and paginate "Post-It" notes in real time.

## Table of Contents

* [Features](#features)
* [Tech Stack](#tech-stack)
* [Prerequisites](#prerequisites)
* [Installation](#installation)
* [Environment Configuration](#environment-configuration)
* [Database Setup](#database-setup)
* [Running Locally](#running-locally)
* [Running Tests](#running-tests)
* [Authentication](#authentication)
* [Frontend Architecture](#frontend-architecture)
* [API Endpoints](#api-endpoints)
* [WebSockets (Optional)](#websockets-optional)
* [Deployment](#deployment)
* [License](#license)

## Features

* **User Authentication**: Stateful auth via Laravel Sanctum, with standard and anonymous login.
* **Create / Read / Update / Delete** Post-It notes.
* **Data Grid**: Server-side filtering (color, size), sorting (by title, created\_at), and pagination (10 items/page).
* **Modals**: Create and view note details in modal dialogs.
* **State Management**: Vue 3 + Pinia store to manage Post-Its and auth state.
* **Inertia.js**: Seamless server-driven pages with client-side routing and state preservation.
* **Vite**: Fast HMR, ES module support, CORS adjustments for Firefox.

## Tech Stack

* **Backend**: Laravel 10.x, Sanctum, Eloquent, Inertia, MySQL/PostgreSQL
* **Frontend**: Vue 3, Inertia.js, Pinia, Axios, Vite
* **Styling**: CSS Variables, Tailwind CSS (optional)
* **Real-time** (optional): Laravel Echo + Pusher / WebSockets

## Prerequisites

* PHP 8.1+ with extensions: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML
* Composer
* Node.js 18+ and NPM/Yarn
* Database: MySQL >=5.7 or PostgreSQL >=9.6
* \[Optional] Pusher account for WebSockets

## Installation

1. **Clone the repo**

   ```bash
   git clone https://github.com/yourusername/post-it-app.git
   cd post-it-app
   ```

2. **Install PHP dependencies**

   ```bash
   composer install
   ```

3. **Install JS dependencies**

   ```bash
   npm install
   # or
   yarn
   ```

4. **Generate app key**

   ```bash
   php artisan key:generate
   ```

## Environment Configuration

Copy `.env.example` to `.env` and update:

```
APP_NAME="Post-It App"
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=postit
DB_USERNAME=root
DB_PASSWORD=secret

# Sanctum / CSRF
SANCTUM_STATEFUL_DOMAINS=localhost:5173
SESSION_DOMAIN=localhost

# (Optional) Pusher
PUSHER_APP_ID=your-id
PUSHER_APP_KEY=your-key
PUSHER_APP_SECRET=your-secret
PUSHER_APP_CLUSTER=mt1
```

## Database Setup

```bash
php artisan migrate
php artisan db:seed  # optional
```

## Running Locally

### 1) Start Laravel Backend

```bash
php artisan serve --port=8000
```

### 2) Start Vite Dev Server

```bash
npm run dev
# or
vite
```

> **Firefox CORS Tip:**
>
> * Ensure `cors: true` in `vite.config.js` under `server`.
> * Add `crossorigin` attribute to your module `<script>` tags in `resources/views/app.blade.php`:
    >
    >   ```blade
>   <script type="module" crossorigin src="http://localhost:5173/@vite/client"></script>
>   <script type="module" crossorigin src="http://localhost:5173/resources/js/app.ts"></script>
>   ```

## Running Tests

```bash
php artisan test
# or with Pest:
./vendor/bin/pest
```

## Authentication

* **Stateless vs. Stateful**: We use **stateful** authentication with Laravel Sanctum for ease of session handling and CSRF protection.
* **Login**: Standard email/password or anonymous login generates a temporary user and issues tokens.

## Frontend Architecture

* **Pinia Stores**: `auth.ts` and `postIts.ts` handle API interactions, CSRF token fetch, and state.
* **Components**:

    * `AppLayout.vue`: Global navigation bar and slot wrapper.
    * `AuthLayout.vue`: Simple layout for login/register without navbar.
    * `Pages/PostIts/Index.vue`: Inertia page combining `Filters.vue`, `Board.vue`, `Pagination.vue`, `CreatePostItModal.vue`, `PostItModal.vue`.
    * `Filters.vue`: Emits filter changes.
    * `Board.vue` (formerly `PostItGrid.vue`): Renders sticky notes.
    * `Pagination.vue`: Emits page navigation.
    * Modal components for create/view.

## API Endpoints

| Method | Endpoint               | Description                   |
| ------ | ---------------------- | ----------------------------- |
| GET    | `/api/post-its`        | List Post-Its (filters, page) |
| POST   | `/api/post-its`        | Create a new Post-It          |
| GET    | `/api/post-its/{id}`   | Show single Post-It           |
| PUT    | `/api/post-its/{id}`   | Update Post-It                |
| DELETE | `/api/post-its/{id}`   | Delete Post-It                |
| POST   | `/api/register`        | User registration             |
| POST   | `/api/login`           | User login                    |
| POST   | `/api/login/anonymous` | Anonymous login               |
| GET    | `/api/user`            | Fetch authenticated user      |
| POST   | `/api/logout`          | Logout                        |

## WebSockets (Optional)

To broadcast real-time note creation:

1. Install & configure `beyondcode/laravel-websockets` or use Pusher.
2. Create an `App\Events\PostItCreated` event implementing `ShouldBroadcast`.
3. Fire the event in `PostItController@store`:

   ```php
   event(new PostItCreated($postIt));
   ```
4. In `resources/js/bootstrap.ts`, configure Echo & Pusher:

   ```js
   import Echo from 'laravel-echo';
   window.Echo = new Echo({
     broadcaster: 'pusher',
     key: process.env.VITE_PUSHER_APP_KEY,
     cluster: process.env.VITE_PUSHER_APP_CLUSTER,
     forceTLS: true,
     auth: { headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') } }
   });
   ```
5. Listen in a Vue component:

   ```js
   Echo.private('post-its')
     .listen('PostItCreated', e => store.postIts.unshift(e.postIt));
   ```

## Deployment

* Build assets:

  ```bash
  npm run build
  ```
* Set `APP_ENV=production` and configure `@vite` directive in Blade.
* Serve via a web server (Nginx / Apache) pointing to `public`.

## License

This project is open-sourced under the MIT license.
