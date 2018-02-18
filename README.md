# PUTINZENJERING
  //todo add short description
  This super cool project was built using Laravel Api builder.

## Installation

1.  Clone source to target machine

        git clone {url to your git repository}



2.  Cd to project directory



3.  You may need to configure some permissions. Directories within the storage 
    and the bootstrap/cache directories should be writable by your web server.



4.  Install composer if not installed already:

        curl -sS https://getcomposer.org/installer | php
        sudo mv composer.phar /usr/local/bin/composer



5.  Install composer dependencies

        composer install


6.  Run migrations

        php artisan migrate --seed


7. Run application (or if you have vhost or vps, then just skip remaining steps and go directly to http://putin.dinkara.com)

        php artisan serve


8. Open browser and type "localhost:8000"


## Building API documentation (Still in development, so some of the routes will be missing...)

1. Install agilio (only first time)

        npm install -g aglio


2. Build

        aglio --theme-variables slate -i documentation/documentation.md -o ./public/docs.html

## Building Postman routes

1. Build collection

        php artisan make:postman --routePrefix="api"


## Updates

1.  Update sources in project directory:
    
        git pull


2.  Update composer dependencies (if composer.json changed):

        composer update

## [Documentation](http://putin.dinkara.com/docs.html)

## [Postman examples](http://putin.dinkara.com/postman/collection.json)

## About Laravel
Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, yet powerful, providing tools needed for large, robust applications. A superb combination of simplicity, elegance, and innovation give you tools you need to build any application with which you are tasked.

## Learning Laravel

Laravel has the most extensive and thorough documentation and video tutorial library of any modern web application framework. The [Laravel documentation](https://laravel.com/docs) is thorough, complete, and makes it a breeze to get started learning the framework.

If you're not in the mood to read, [Laracasts](https://laracasts.com) contains over 900 video tutorials on a range of topics including Laravel, modern PHP, unit testing, JavaScript, and more. Boost the skill level of yourself and your entire team by digging into our comprehensive video library.