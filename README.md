Installations
1 - $ composer install
2 - $ cp .env.example .env
3 - configure database settings in .env like below / .env dosyasında veri tabanı ayarlarını aşagıdaki gibi ayarla
...
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=db_name
DB_USERNAME=db_user
DB_PASSWORD=db_password
...
4 - $ php artisan key:generate && php artisan jwt:secret && php artisan config:cache && php artisan migrate
5 - $ php artisan db:seed
6 - Login with email: test@mail.com, password: 123456