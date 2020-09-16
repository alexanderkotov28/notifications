### Install
* Add to your composer.json
```json
"require":{
  "alexanderkotov28/notifications": "^0.04"
},
"repositories": {
        "alexanderkotov28/notifications": {
            "type": "vcs",
            "url": "https://github.com/alexanderkotov28/notifications.git"
        }
    }
```
* Install
```shell script
composer update
```

* Publish vendor
```shell script
php artisan vendor:publish
```

* Migrations
```shell script
php artisan migarte
```

### Configure
Fill config in your config/notifications.php

### Usage
Telegram
```php
   Notification::telegram(1340105811)->text('Какой-то текст')->date(Carbon::now()->addMinutes(2));
   Notification::telegram(1340105811)->text('Какой-то текст')->send();
```

Email
```php
$result = Notification::email('alexander.tersky@gmail.com')->subject('Subject')->text('Какой-то текст')->fromName('Test')->send();
```
