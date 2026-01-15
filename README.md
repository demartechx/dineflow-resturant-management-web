# DineFlow 🍽️

**DineFlow** is a modern, QR-based restaurant management system designed to streamline the ordering process. It bridges the gap between customers and the kitchen with a premium, mobile-first frontend and a powerful administration panel.

![DineFlow Banner](https://placehold.co/1200x400/ea580c/ffffff?text=DineFlow+Restaurant+System)

## ✨ Key Features

### 📱 Customer Frontend

-   **QR Code Ordering**: Customers scan a table-specific QR code (e.g., `/table/1`) to start ordering.
-   **Deep Design UI**: A visually stunning, mobile-optimized interface featuring glassmorphism, smooth gradients, and deep shadows.
-   **Interactive Menu**:
    -   Real-time search functionality.
    -   Sticky category navigation (e.g., Rice, Drinks).
    -   Instant filtering without page reloads.
-   **Cart System**: Seamless add-to-cart experience with quantity management.
-   **Checkout**: Simple checkout process supporting Bank Transfer and Cash methods.
-   **Order Tracking**: Real-time status updates for customers to track their food preparation.

### 🛠 Admin Backend (FilamentPHP)

-   **Dashboard**: At-a-glance visualization of Total Orders, Pending Orders, and Revenue.
-   **Order Management**: View, update, and process orders (Pending → Preparation → Served → Paid).
-   **Menu Management**: tailored management for Products, Categories, and Ingredients.
-   **Table Management**: Generate and manage restaurant tables.
-   **Currency Support**: Localized for Nigerian Naira (₦).

## 🚀 Tech Stack

-   **Framework**: [Laravel 11](https://laravel.com)
-   **Frontend**: [Livewire 3](https://livewire.laravel.com), [Alpine.js](https://alpinejs.dev), [TailwindCSS](https://tailwindcss.com)
-   **Admin Panel**: [FilamentPHP v3](https://filamentphp.com)
-   **Database**: MySQL / SQLite

## 🛠️ Installation

### Prerequisites

-   PHP 8.2+
-   Composer
-   Node.js & NPM

### Steps

1.  **Clone the Repository**

    ```bash
    git clone https://github.com/demartechx/dineflow-resturant-management-web.git
    cd dineflow
    ```

2.  **Install PHP Dependencies**

    ```bash
    composer install
    ```

3.  **Install Frontend Dependencies**

    ```bash
    npm install
    ```

4.  **Environment Setup**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

    _Configure your database settings in the `.env` file._

5.  **Database Migration & Seeding**

    ```bash
    php artisan migrate --seed
    ```

    _This will create the default admin user and sample menu items._

6.  **Create Storage Link**

    ```bash
    php artisan storage:link
    ```

7.  **Build Assets**

    ```bash
    npm run build
    ```

8.  **Run the Application**
    ```bash
    php artisan serve
    ```

## 📖 Usage Guide

### Customer Flow

1.  Visit `/table/1` (simulating a QR scan for Table #1).
2.  Browse the menu, filter by category, or search for items.
3.  Add items to your cart.
4.  Proceed to checkout and select your payment method.
5.  Track your order status on the tracking page.

### Admin Access

1.  Visit `/admin`.
2.  Login with the default credentials (seeded):
    -   **Email**: `admin@dineflow.com` (or check database seeder)
    -   **Password**: `password`
3.  Manage incoming orders from the "Latest Orders" widget or the Orders resource.

## 🤝 Contributing

Contributions are welcome! Please fork the repository and submit a pull request for any improvements.

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
