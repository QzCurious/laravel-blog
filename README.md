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

## Laravel Makes Authentication Easy

Laravel comes with migrations for users and password resets.
To make a basic authentication system simply run:

```php
$ php artisan migrate
```

Another helpful artisan command makes routes and views for
authentication and registration:

```php
$ php artisan make:auth
```

_With help of git, you can see what is done by `make:auth`._
_You can also checkout this by `$ git show make-auth` in this repo._

Now your app is ready for registration and authentication. Just that easy!

## Create Migration and Model for Posts

### Make Migration with Artisan

`php artisan make:migration create_posts_table --create=posts`

-   Artisan creates a new migration file placed in **database/migratoins** for us
-   Option **--create** set name of table to be created.
-   `php artisan help make:migration` to learn more.

### Migration Basics

> A migration class contains two methods: up and down. The up method is used
> to add new tables, columns, or indexes to your database, while the down method
> should reverse the operations performed by the up method.
>
> --[Laravel](https://laravel.com/docs/5.8/migrations#generating-migrations)

### Posts Migration

_database/migrations/YYYY_MM_DD_hhmmss_create_posts_table.php_

| Field     | command                                                                                                 |
| --------- | ------------------------------------------------------------------------------------------------------- |
| id        | `\$table->bigIncrements('id');`                                                                         |
| author_id | `\$table->bigInteger('author_id')->unsigned();`                                                         |
|           | `\$table->foreign('author_id')->referces('id')->on('users')->onUpdate('cascade')->onDelete('cascade');` |
| title     | `\$table->string('title');`                                                                             |
| content   | `\$table->text('content');`                                                                             |
| delete_at | `\$table->softDeletes();`                                                                               |
| create_at | `\$table->timestamps();`                                                                                |
| update_at | `\$table->timestamps();`                                                                                |

`php artisan migrate`

### Post Model (Eloquent Model)

> The Eloquent ORM included with Laravel provides a beautiful, simple
> ActiveRecord implementation for working with your database.
> Each database table has a corresponding "Model" which is used to
> interact with that table. Models allow you to query for data in your tables,
> as well as insert new records into the table.
>
> --[Laravel](https://laravel.com/docs/5.8/eloquent#introduction)

```
php artisan make:model Post
```

_You can generate model with migration at the same time by_
_`php artisan make:model Post --migration`_

#### Eloquent Model Conventions

By convention, the "snake case", plural name of the class will be used as
the table name. So, in this case, Eloquent will assume the Post model
stores records in the posts table.

## Build Up Blog Post functionality

### Post Controller

```sh
$ php artisan make:controller PostController --resource --model=Post
```

### Resourceful Route

Registe routes for resource controller

```php
Route::resource('posts', 'PostController');
```

To use only subset of actions of resourceful route

```php
Route::resource('posts', 'PostController')->only(['index', 'show']);
Route::resource('posts', 'PostController')->except(['destroy']);
```

[Resource controller](https://laravel.com/docs/5.8/controllers#resource-controllers)

| Verb      | URI                | Action  | Route Name    |
| --------- | ------------------ | ------- | ------------- |
| GET       | /posts             | index   | posts.index   |
| GET       | /posts/create      | create  | posts.create  |
| POST      | /posts             | store   | posts.store   |
| GET       | /posts/{post}      | show    | posts.show    |
| GET       | /posts/{post}/edit | edit    | posts.edit    |
| PUT/PATCH | /posts/{post}      | update  | posts.update  |
| DELETE    | /posts/{post}      | destroy | posts.destroy |

### Build Post CRUD

#### Frontend Resources

We will need bootstrap to build our frontend view. You are free to
prune any package that not needed in _package.json_.

Install javascript packages

```sh
$ npm install
```

[Laravel Mix](https://laravel.com/docs/5.8/mix) is included in
_package.json_. I'm curious about how modern frondend techniques.
So I will try to follow the steps I can find.

_Laravel is built on top of Webpack._

Compile frontend resources

```sh
$ npm run dev
```

Destinations for compiled resources is set by _webpack.mix.js_, which is the
config file for Laravel Mix. Destination is specified by second argument of
`js()` and `sass()`.

Compiled resources are not needed to be include into VCS. So I'll add
them into _.gitignore_.

```.gitignore
.gitignore
----------

# compiled resource
/public/css/
/public/js/
/public/mix-manifest.json
```

But there is a problem, although I specified those files in _.gitignore_,
`$ git status` still showing me those files. The reason is, Laravel project
comes with those files, which are already tracked by git. So there is one
more step to do - remove those files for this commit.

```sh
# --cache flag tells git remove indexed files only, not files in working directory
$ git rm --cache -r /public/css/*
$ git rm --cache -r /public/js/*
```

#### Post Routes

I will explicitly declare all routes and follow resourceful route conventions
for our posts. [#why](#why-explict-declare-all-routes-instead-of-use-resourceful-route)

```php
web.php
-------

use App\Http\Controllers\PostController;

Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/create', [PostController::class, 'create']);
Route::post('/posts', [PostController::class, 'store']);
Route::get('/posts/{post}', [PostController::class, 'show']);
Route::get('/posts/{post}/edit', [PostController::class, 'edit']);
Route::patch('/posts/{post}', [PostController::class, 'update']);
Route::put('/posts/{post}', [PostController::class, 'replace']);
Route::delete('/posts/{post}', [PostController::class, 'destory']);
```

##### Register Routes By Pass an Array As Callable

Usually, a route is declared as `Route::get('/posts', 'PostController@index');`.
There is another way to registering a route,
[array as callable](https://www.php.net/manual/en/language.types.callable.php#language.types.callable.passing).
~~Although it does not documented in Laravel official documentation, but is introduced
[here](https://github.com/laravel/framework/pull/24385)~~. This syntax makes IDEs
easy to navigate to code definition. One thing to notice, `::class` is a method,
the class at this point should be understood by php. You can either import the
class by `use` or specify a
[full qualified name](https://www.php.net/manual/en/language.namespaces.basics.php).

**One thing to notice:** The main perporse is to make the code more close to php.
So that IDEs can understand and takes advantage of it.
`RouteServiceProvider` assign a default namespace, `App\Http\Controllers` for
each route. Using `Route::resource('posts', PostController::class)` would cause problem.

#### Page for Create a Post

Laravel comes with a _resources/views/layouts/app.blade.php_ blade file.
I'll **extend** it for out posts view.

Create view _resources/views/post/create.blade.php_ and let
`PostController::create` load the view by:

```php
PostController.php
------------------

public function create()
{
    return view('posts.create');
}
```

`view` function search file in _resources/views_. `.` or `/` represents
directory structure.

Blade directives to be aware of:

-   {{ }}
-   [@section](https://laravel.com/docs/5.8/blade#defining-a-layout)
-   [@yield](https://laravel.com/docs/5.8/blade#defining-a-layout)
-   [@extends](https://laravel.com/docs/5.8/blade#extending-a-layout)
-   [@csrf](https://laravel.com/docs/5.8/blade#csrf-field)

#### Page for List of Posts

Create view _resources/views/post/index.blade.php_ and let
`PostController::index` load the view by:

```php
PostController.php
------------------

public function index()
{
    $posts = Post::orderBy('created_at', 'desc')->get();

    return view('post.index', compact('posts'));
}
```

#### Page for a Post

view: _resources/views/post/show.blade.php_

```php
PostController.php
------------------

public function show($post)
{
    $post = Post::find($post);
    return view('post.show', compact('post'));
}
```

Recall we declare a placeholder `{post}` in route:

```php
Route::get('/posts/{post}', [PostController::class, 'show']);
```

It's called [route parameter](https://laravel.com/docs/5.8/routing#route-parameters)
A route parameter is encased within `{}`. Then it is passed to controller.
We take it as id of a post.

# Environment

-   php 7.3.3
-   composer 1.8.4
-   laravel/laravel v5.8.3
-   laravel/framework v5.8.10
-   bootstrap v4.3.1

# Notes

## laravel/laravel vs laravel/framework

[laravel/framework](https://github.com/laravel/framework) is core of laravel.
[laravel/laravel](https://github.com/laravel/laravel) is a part of app that
you with. It provides default structure for laravel project.
The repository contains default config files, controllers, routes, etc. As well as
code responsible for bootstrapping the application.
And it requires laravel/framework as dependency.

# Why

## Why Explict Declare All Routes Instead of Use Resourceful Route

-   We can use `where()` method to constrain route
    parameters on normal routes (`Route::post()`).
    I think it is a good practice to do it.
    See also [How to constrain route parameters of resourceful route](#How-to-constrain-route-parameters-of-resourceful-route)
-   I like use [array as callable] for a route.
-   Routes for web and api are split to separate files.
    Usually we don't declare an api routes in _web.php_, vice versa.
    Using `Route::resource()` and `Route::apiResource()` is just a quick way
    to declare routes. While `except()` or `only()` just
    make things more complicate.

# How

## How to constrain route parameters of resourceful route

First, name the parameter for a resourceful route:

```php
Route::resource('posts', 'PostController')->parameters([
    // resource_name => parameter_name
    'posts' => 'id'
]);
```

Then define [global constrain](https://laravel.com/docs/5.8/routing#route-parameters):

```php
RouteServiceProvider.php
------------------------

public function boot()
{
    Route::pattern('id', '[0-9]+');

    parent::boot();
}
```

# TODO

[Frontend Resources](#frontend-resources)

-   Understand how resources are compiled
-   [webpack tutorial](https://medium.com/a-beginners-guide-for-webpack-2)
