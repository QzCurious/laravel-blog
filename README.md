# laravel-blog

Learning laravel by making a blog.

# Steps

## Install Composer

To install [composer](https://getcomposer.org), copy the code snippet from
[Download Composer](https://getcomposer.org/download/) and run it on terminal.

To access composer globally, check
[Composer Getting Started](https://getcomposer.org/doc/00-intro.md)

Now you should be able to run `composer --version`

### Composer Version

`Composer version 1.8.4 2019-02-11 10:52:10`

## Create Laravel project

This project is build with
[laravel/laravel:v5.8.3](https://github.com/laravel/laravel/tree/v5.8.3)

See alse: https://laravel.com/docs/5.8

### Server Requirements for Laravel

Make sure the [requirements](https://laravel.com/docs/5.8/installation#server-requirements)
are met.

Php version should be greater then 7.1.3

Install and enable php extensions:

-   OpenSSL PHP Extension
-   PDO PHP Extension
-   Mbstring PHP Extension
-   Tokenizer PHP Extension
-   XML PHP Extension
-   Ctype PHP Extension
-   JSON PHP Extension
-   BCMath PHP Extension

### Install Laravel

`$ composer create-project --prefer-dist laravel/laravel laravel-project laravel-blog`

### Local Development Server

`$ php artisan serve`

### Configuration

#### Public Directory

Configure web server's document / web root to be the public directory.

For apache virtual host (note that the path may not suit for you):

```apache
/etc/httpd/conf/extra/httpd-vhosts.conf
---------------------------------------

<VirtualHost laravel-blog.test:80>
    DocumentRoot "/home/qz/public_html/laravel-blog/public"
    ServerName laravel-blog.test
    ErrorLog "/var/log/httpd/laravel-blog.test-error_log"
    CustomLog "/var/log/httpd/laravel-blog.test-access_log" common

    <Directory "/home/qz/public_html/laravel-blog/public">
        Options FollowSymLinks MultiViews
        AllowOverride FileInfo Options=All,MultiViews
        Require all granted
    </Directory>
</VirtualHost>
```

#### Directory Permissions

Give write permission of _storage_ and _bootstrap/cache_ to web server.
The easiest way: `$ chmod -R 777 storage bootstrap/cache`. **WARNING: You
probably won't want this setup on production server.**

#### .env file

`$ cp .env.example .env`

_.env_ file is copied if you install laravel by composer.

_.env_ file should not be committed on VCS, since each developer usually
have their own configuration. Furthermore, you won't want your credentials
to be exposed.

Create a database for this project and set `DB_*` in _.env_

```.env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel-blog
DB_USERNAME=root
DB_PASSWORD=root
```

#### Application Key

`$ php artisan key:generate`

> If the application key is not set, your user sessions and other
> encrypted data will not be secure!
>
> --[Laravel](https://laravel.com/docs/5.8#configuration)

#### .htaccess

Laravel include a _public/.htaccess_ file. For apache, be sure to enable
the **mod_rewrite** module.

Uncomment line `LoadModule rewrite_module modules/mod_rewrite.so` in
apache config file. For archlinux, the config file is located at
_/etc/httpd/conf/httpd.conf_

See also: https://laravel.com/docs/5.8#web-server-configuration

## Basic Routing and Views

### What is Routing

> Routing is the process of parsing a URI and determining
> the appropriate action to take.
>
> --[Building a PHP Framework: Part 8 - Routing](https://dev.to/mattsparks/building-a-php-framework-part-8---routing-4jgf)

### Register a Simple Route

> The routes/web.php file defines routes that are for your web interface.
>
> --[Laravel](https://laravel.com/docs/5.8/routing#basic-routing)

```php
routes/web.php
--------------

Route::get('/', function () {
    return view('welcome');
});
```

Laravel comes with a route. So that you will see a landing pages
when you visit / page.

Name of `get()` method is respond to HTTP verb.
First argument is a uri, and second is the action for the uri.

And there are more:

```php
Route::get($uri, $callback);
Route::post($uri, $callback);
Route::put($uri, $callback);
Route::patch($uri, $callback);
Route::delete($uri, $callback);
Route::options($uri, $callback);
```

The `view()` function retrieves a view instance by search
files in _resources/views/_ directory.

Now create a simple route:

```php
routes/web.php
--------------

Route::get('/about', function () {
    return 'About...';
});
```

Run `$ php artisan serve` and visit http://localhost:8000/about.
You should see "About..." on the page.

### Create a Simple View

It's not enough to just show a string in a page. We shall write
html code for our pages. That's what views for. You can just think that
views are pages, so you write html code in view files. Laravel manages
views in _resources/views/_ directory. In _resources/views/_ you see
laravel come with a _welcome.blade.php_ file.
[**Blade**](https://laravel.com/docs/5.8/blade) is laravel template engine
for frontend. To create a view for about page, create a new file
_about.blade.php_ in _resources/views/_. For now, we can just treat it
as normal html file.

```php
about.blade.php
---------------

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About</title>
</head>
<body>
    <h1>About This Blog</h1>
</body>
</html>
```

Then modify [our route](#register-a-simple-route)

```php
routes/web.php
--------------

Route::get('/about', function () {
    return view('about');
});
```

Run `$ php artisan serve` and visit http://localhost:8000/about.
You should see our html is rendered.

# Environment

-   php 7.3.3
-   composer 1.8.4
-   laravel/laravel v5.8.3
-   laravel/framework v5.8.10

# Notes

## laravel/laravel vs laravel/framework

[laravel/framework](https://github.com/laravel/framework) is core of laravel.
[laravel/laravel](https://github.com/laravel/laravel) is a part of app that
you with. It provides default structure for laravel project.
The repository contains default config files, controllers, routes, etc. As well as
code responsible for bootstrapping the application.
And it requires laravel/framework as dependency.
