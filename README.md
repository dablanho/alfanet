## Installations / Kurulum

- $ composer install
- $ cp .env.example .env
- configure database settings in .env like below / .env dosyasında veri tabanı ayarlarını aşagıdaki gibi ayarla
```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=db_name
DB_USERNAME=db_user
DB_PASSWORD=db_password
```
- $ php artisan key:generate && php artisan jwt:secret && php artisan config:cache && php artisan migrate
- $ php artisan db:seed
- Login with email: test@mail.com, password: 123456
