# Arabic RTL ERP Invoice Module
A Laravel-based Arabic RTL invoice management assessment project.

## Features
- Arabic RTL Interface
- Customer Management
- Customer Dropdown Selection
- Add Customer via Modal Form
- Dynamic Invoice Items
- Quantity, Unit Price, Discount & Tax
- Live Frontend Calculations
- Server-Side Validation
- Server-Side Recalculation Before Saving
- Invoice & Item Storage in MySQL
- Invoice Listing
- Invoice Details View
- Arabic RTL PDF Generation

## Requirements
- PHP 8.3+
- Laravel 13
- MySQL
- Composer

## Installation
Clone repository
composer install

Create .env
cp .env.example .env
Database setup

php artisan migrate
Run project
php artisan serve

## Notes
- No seeders are required.
- Run migrations to create all database tables.

### Customers
Create and select customers


### Invoices
- Create invoice
- Add multiple items
- Apply discount
- Apply tax
- Calculate totals


### PDF
Generate Arabic RTL invoice PDF



## Tech Stack
- Laravel 13.16.1
- PHP 8.3.14
- MySQL
- Bootstrap 5
- jQuery
- mPDF