cp .env.example .env
composer install
php artisan migrate --seed
php artisan key:generate
php artisan serve --host 0.0.0.0
