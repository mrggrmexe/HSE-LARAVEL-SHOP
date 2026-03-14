# HSE Laravel Shop

## Локальный запуск

```bash
cd shop
composer install
npm install
php artisan optimize:clear
php artisan migrate:fresh --seed
php artisan storage:link
npm run build
composer run dev
