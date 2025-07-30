# Restaurant Website

A modern restaurant management system built with Laravel, featuring both admin and client interfaces.

## Features

### Admin Panel

-   **Dashboard**: Overview of orders, products, and categories
-   **Category Management**: CRUD operations for food/drink categories
-   **Product Management**: Add, edit, delete menu items with images
-   **Order Management**: View and manage customer orders
-   **Order Status Updates**: Update order and payment status
-   **File Upload**: Image upload for categories and products

### Client Interface

-   **Menu Display**: Attractive menu with category filtering
-   **Product Search**: Search functionality for menu items
-   **Shopping Cart**: Add, update, remove items from cart
-   **Checkout Process**: Complete order placement with customer details
-   **Order Confirmation**: Order summary and confirmation page
-   **Responsive Design**: Mobile-friendly interface

## Technology Stack

-   **Backend**: Laravel 12 (PHP 8.4)
-   **Frontend**: Bootstrap 5, Font Awesome, JavaScript
-   **Database**: SQLite (can be changed to MySQL/PostgreSQL)
-   **File Storage**: Laravel Storage with public disk

## Installation

### Prerequisites

-   PHP 8.4 or higher
-   Composer
-   Node.js (for asset compilation)

### Setup Steps

1. **Clone the repository**

    ```bash
    git clone <repository-url>
    cd resto-app
    ```

2. **Install PHP dependencies**

    ```bash
    composer install
    ```

3. **Environment setup**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Database setup**

    ```bash
    php artisan migrate
    php artisan db:seed
    ```

5. **Storage setup**

    ```bash
    php artisan storage:link
    ```

6. **Start the development server**
    ```bash
    php artisan serve
    ```

The application will be available at `http://localhost:8000`

## Database Structure

### Tables

-   **categories**: Food and drink categories
-   **products**: Menu items with prices and descriptions
-   **orders**: Customer orders with status tracking
-   **order_items**: Individual items in each order

### Sample Data

The application comes with sample data including:

-   8 categories (Main Dishes, Appetizers, Soups, Salads, Desserts, Hot Drinks, Cold Drinks, Alcoholic Beverages)
-   18 products across different categories

## Usage

### Admin Access

-   Navigate to `/admin/dashboard` for admin panel
-   Manage categories, products, and orders
-   Upload images for categories and products

### Client Access

-   Homepage displays the menu
-   Browse categories and products
-   Add items to cart
-   Complete checkout process

## File Structure

```
resto-app/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/           # Admin controllers
│   │   └── Client/          # Client controllers
│   └── Models/              # Eloquent models
├── database/
│   ├── migrations/          # Database migrations
│   └── seeders/            # Database seeders
├── resources/
│   └── views/
│       ├── admin/          # Admin views
│       ├── client/         # Client views
│       └── layouts/        # Layout templates
└── routes/
    └── web.php             # Application routes
```

## Key Features

### Admin Features

-   **CRUD Operations**: Full Create, Read, Update, Delete for categories and products
-   **Image Management**: Upload and manage images for categories and products
-   **Order Management**: View, update status, and manage customer orders
-   **Dashboard Analytics**: Overview of orders, products, and categories

### Client Features

-   **Responsive Menu**: Mobile-friendly menu display
-   **Category Filtering**: Filter products by category
-   **Search Functionality**: Search products by name or description
-   **Shopping Cart**: Session-based cart management
-   **Order Processing**: Complete checkout with customer information

## Customization

### Adding New Categories

1. Go to Admin Panel → Categories
2. Click "Add New Category"
3. Fill in name, description, and upload image
4. Set active status

### Adding New Products

1. Go to Admin Panel → Products
2. Click "Add New Product"
3. Fill in product details
4. Select category and upload image
5. Set price and availability

### Modifying Styles

-   Edit `resources/views/layouts/app.blade.php` for main styling
-   Customize Bootstrap classes and CSS
-   Add custom JavaScript in the scripts section

## Security Features

-   **CSRF Protection**: All forms include CSRF tokens
-   **File Upload Validation**: Image upload validation and security
-   **Input Validation**: Server-side validation for all inputs
-   **SQL Injection Protection**: Laravel's Eloquent ORM protection

## Performance Optimizations

-   **Eager Loading**: Relationships loaded efficiently
-   **Image Optimization**: Proper image storage and serving
-   **Database Indexing**: Optimized database queries
-   **Caching**: Session-based cart management

## Deployment

### Production Setup

1. Set environment variables for production
2. Configure database connection
3. Set up file storage (AWS S3 recommended for production)
4. Configure web server (Apache/Nginx)
5. Set up SSL certificate

### Environment Variables

```env
APP_ENV=production
APP_DEBUG=false
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=restaurant_db
DB_USERNAME=username
DB_PASSWORD=password
```

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

For support and questions, please contact the development team or create an issue in the repository.

---

**Note**: This is a demo application. For production use, additional security measures, authentication, and payment processing should be implemented.
