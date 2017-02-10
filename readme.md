<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

## Laravel 5.4 Authentication Template

Laravel 5.4 Authentication Template with Facebook and Google OAuth

## Installation
- git clone https://github.com/MangTomas23/laravel-authentication'
- cd laravel-authentication
- composer install
- cp .env.example .env
- php artisan key:generate
- php artisan migrate

## Notes
- Make sure you have created a new database and setup the `.env` file before running `php artisan migrate`
- You need to have a valid app id to enable facebook and google auth; You can get one at https://developers.facebook.com and https://developers.google.com
