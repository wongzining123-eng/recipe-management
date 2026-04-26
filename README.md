## Before coding

## 1. Clone
git clone https://github.com/wongzining123-eng/recipe-management.git
cd recipe-management

## 2. Restore vendor folder
composer install

## 3. Restore node_modules
npm install

## 4. Create .env from template
cp .env.example .env

## 5. Generate app key (fills APP_KEY in .env)
php artisan key:generate

## 6. Create database in phpMyAdmin manually
http://localhost/phpmyadmin → New → recipe_management

## 7. Run Migrations
php artisan migrate/ php artisan migrate:fresh (if any updates)

## 8. Run Seeders
php artisan db:seed
