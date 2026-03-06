# School Management System (SMS)

## System Requirements

- PHP 8.3+
- Composer 2.12+
- MySQL 8+
- Node.js 18+
- Laravel 11
- Web Server (Apache/Nginx)

## Installation Steps

### 1. Clone Repository

```bash
git clone https://github.com/codewin1803/sms.git
cd sms

### 2. Install Dependencies

composer install
npm install
npm run build

### 3. Configure Environment

cp .env.example .env
php artisan key:generate

Update DB credentials in .env

### 4. Run Migrations

php artisan migrate --seed

### 5. Start Server

php artisan serve

Access at:
<a href="http://127.0.0.1:8000
