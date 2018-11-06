# Weather API package to Laravel

A simple weather package for Laravel

### Installation

Require package by composer

```
composer require olek/weather
```

Service Provider

```
'providers' => [
    ...
    Olekjs\Weather\ServiceProvider::class,
];
```

## Publish config

```
php artisan vendor:publish --provider=Olekjs\\Weather\\ServiceProvider
```

## Package settings

Set your APPID in .env file

You can find the key on [openweathermap](https://openweathermap.org/) page
```
WEATHER_APP_ID=your_appid
```

### Usage

```
use Olekjs\Weather\Facade as Weather;

Weather::getByCity('London');
Weather::getByCoords(10,100);
```

### Features
* Add a method that will change the units
* Add more opportunities to find the weather
* Add views for the weather
