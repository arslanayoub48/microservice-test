#Laravel Authentication and Product Management Microservice
#Overview
This microservice is built using Laravel 11 and provides endpoints for user registration, login, logout, and role-based product management (CRUD operations). It uses JWT-based authentication (via Laravel Passport) and Swagger for API documentation.

#Features
User Authentication: Register, login, logout, and authentication using JWT tokens.
Role-Based Access Control: Only authorized users can create, update, and delete products.
Product Management: Perform CRUD operations on products (Admin only).
Swagger Documentation: Interactive API documentation for easier integration and testing.
#Requirements
PHP 8.1+
Composer
MySQL or any other database supported by Laravel
Node.js and NPM (for running frontend dependencies if needed)
Laravel 11
Laravel Passport (for JWT authentication)
#Setup Instructions
Install Dependencies
Run the following command to install the PHP dependencies:
####composer install
####php artisan migrate
####php artisan l5-swagger:generate
####php artisan test



