# Laravel-CleverReach

![Laravel CleverReach](img/laravel-clever-reach.png)

**Integration for the v3 API**

This package is a boiler plate for using the CleverReach API v3.
It contains Actions and Livewire components to handle Groups, Forms and
Subscribers. You can generate newsletter lists complete with form/group ID
for generating easy signup forms.

**Only Laravel 9/10 are currently supported**

### Docs

-   [Installation](#installation)
-   [Laravel compatibility](#laravel-compatibility)

## Installation

### Install package

Add the package in your composer.json by executing the command.

```bash
composer require ultraboldma/clever-reach
```

Laravel CleverReach features auto discover for Laravel. In case this fails, just add the
Service Provider to the app.php file.

```
UltraboldMA\CleverReach\CleverReachServiceProvider::class,
```

### Publishing everyting

Since we're focused on providing a working boiler plate, all necessary files will be
published to your application structure. You can also publish individual parts if needed.

```bash
php artisan clever-reach:publish
```

### Migrations

During the publishing process the migrations were also published.
This will generate all tables you need.

```bash
php artisan migrate
```

### Menu items

There is no menu included with this package. You will need to build your own and
link to the routes that were published.

### Tailwind

All elements in this package are based on Tailwind and come with minimal styling.
If needed you can adjust the published views to fit whatever framework you're using.

## Configuration

### Base URL

Base URL for the CleverReach v3 API. It's already set for you.

```php
'baseUrl' => 'url of api'
```

### Single Client

You have the option to run multiple API clients for interacting
with multiple CleverReach accounts.

```php
'singleClient' => true
```

### Available languages

You can create newsletters with different languages/locales in the DB,
if you wish to load the based on your app's locale. Please list the
available languages here.

```php
'available_languages' => ['de', 'en']
```

### Default group ID

If you always want to use a default group for your newsletter signups,
you can set that here. (not yet available)

```php
'default_group_id' => 39843984
```

### Default form ID

Same as the default group ID. (not yet available)

```php
'default_form_id' => 39839483
```

## Laravel compatibility

| Laravel | LaravelCM |
| :------ | :-------- |
| 10.x    | >0.0.\*   |
| 9.x     | >0.0.\*   |

Lower versions of Laravel are not supported.
