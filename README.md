# Arabic RTL ERP Invoice Module

## Features
- Laravel Invoice Management
- Arabic RTL Interface
- Customer Management
- Invoice Creation
- Dynamic Invoice Items
- Live Calculation
- Server Side Validation
- PDF Invoice Generation
- MySQL Database Storage

## Requirements
- PHP >= 8
- Laravel
- MySQL
- Composer

## Installation
Clone repository

composer install

Create .env
cp .env.example .env

Generate key
php artisan key:generate
Database setup

php artisan migrate
Run project
php artisan serve



## Modules


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
- Laravel
- PHP
- MySQL
- Bootstrap
- jQuery
- mPDF