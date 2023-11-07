# Absensi PJBL PKL

## Server Side Application
Restful API Service

# Setup
1. `composer install`
2. `cp .env.example .env`
setup your database in .env file
#### example
    ```
    DB_DATABASE=absensi_pjbl_pkl
    DB_USERNAME=your_mysql_username
    DB_PASSWORD=your_mysql_password
     ``
3. `php artisan key:generate`
4. `php artisan jwt:secret`
5. `php artisan migrate`
6. `php artisan storage:link`

# API Specification Documentation
[Here](https://app.swaggerhub.com/apis-docs/akmmp241/Absensi/1.0.0)
