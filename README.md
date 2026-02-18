# ITBantex Inventory Request System

ITBantex is an internal inventory request and stock confirmation system built with  
**Laravel 12 + Breeze + TailwindCSS + Excel Export**.

Employees can submit item requests and export them into Excel, while admins confirm incoming stock through transactions.

---

## Features

### Employee Side
- Login system (Laravel Breeze)
- Create & manage item requests
- Export requests into Excel documents
- Export history + reprint anytime

### Admin Side
- Admin dashboard overview
- Sync Item Master from Excel
- Stock transaction approval (Approve / Reject)
- Track pending & completed transactions

---

## Tech Stack

- Laravel 12
- Breeze Authentication
- TailwindCSS
- MySQL Database
- Maatwebsite Excel + PhpSpreadsheet

---

## Requirements

Make sure you already have:

- PHP 8.2+
- Composer
- Node.js + NPM
- MySQL / MariaDB
- XAMPP (Windows recommended)

---

## Installation (Full Setup Order)

Follow this exact order after cloning the project:

## Installation (Full Setup Order)
Follow this exact order after cloning the project:

```bash
### Clone Reposity

```bash
git clone https://github.com/Hawariii/ITbantex.git
cd ITbantex

### 2. Install Backend Dependencies

```bash
composer install

if you get an error

uncomment:
```\xampp\php\php.ini
extension=gd
extension=zip

### 3. Setup ENV File

```bash
cp .env.example .nv

### 4. Generate App Key

```bash
php artisan key:generate

### 5. Configure Database

edit .env :
DB_DATABASE=your db
DB_USERNAME=your username
DB_PASSWORD=

Then create database in phpMyAdmin like in DB_DATABASE

### 7. Run Migrations

```bash
php artisan serve

### 8. Install Frontend Depedencies

```bash
npm install

### 9. Start Server

```bash
npm run dev
php artisan serve

open http://127.0.0.1:8000

## Notes
- Excel export requires gd + zip extensions enable
- Admin pages are protected with AdminMiddleware

## Author
Built by Ahmad Hawari
Internal inventory + stock approval workflow system
