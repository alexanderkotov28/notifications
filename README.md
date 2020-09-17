### Установка
* Добавить в composer.json
```json
"require":{
  "alexanderkotov28/notifications": "^1.0"
},
"repositories": {
        "alexanderkotov28/notifications": {
            "type": "vcs",
            "url": "https://github.com/alexanderkotov28/notifications.git"
        }
    }
```
* Установить пакет
```shell script
composer update
```

* Добавляем миграцию, конфиг и консольную команду
```shell script
php artisan vendor:publish
```

* Применяем миграции
```shell script
php artisan migarte
```

### Конфигурация
* Необходимо заполнить config/notifications.php
* Для отправки уведомлений в определённое время необходимо выполнять консольную команду по крону или как-либо ещё
  ```shell script
  php artsian notification:send
  ```

### Использование
```php
use AlexanderKotov\Notifications\Notification;
```
####Telegram
В метод telegram() передаём id пользователя или массив с несколькими id.
```php
   // Отправить прямо сейчас
   Notification::telegram(1340105811)->text('Какой-то текст')->send();
   // Отправить в определённое время
   Notification::telegram(1340105811)->text('Какой-то текст')->date(Carbon::now()->addMinutes(2));
```

####Email
В метод email() передаём email получателя или массив с несколькими email.  
subject() - Тема письма  
text() - Содержимое письма  
fromName() - Имя отправителя

```php
// Отправить прямо сейчас
Notification::email('mal@example.com')->subject('Subject')->text('Какой-то текст')->fromName('Test')->send();
// Отправить в определённое время
Notification::email('mal@example.com')->subject('Subject')->text('Какой-то текст')->fromName('Test')->date(Carbon::now()->addMinutes(2));
```

####Push
В метод push() передаём id пользователя  
text() - Содержимое пуша  
```php
// Создаст пуш без времени
Notification::push(1)->text('Какой-то текст')->send();
// Создаст пуш на определённое времени
Notification::push(1)->text('Какой-то текст')->date(Carbon::now()->addMinutes(2));
```

С пушами так же можно работать через Модель пользователя с помощью трейта Push
```php
use \AlexanderKotov\Notifications\Traits\Push;

class User extends Model{
    use Push;
}

$user = User::find(1);
// Получение всех пушей
$user->pushes;

// Получение непоказанных пушей
$user->recentPushes;

// Пометить пуш показанным
$user->pushes()->first()->setExecuted();

// Создать пуш для пользователя
$user->notificationPush('Текст');
$user->notificationPush('Текст', Carbon::now()->addMinutes(2));
```

#### Возвращаемые значения
Метод send() возвращает объект класса Response с двумя свойствами:
1. status
2. message (только при ошибке)
Чтоюы получить json, приведите Response к строке, например:
```php
$response = Notification::telegram(1340105811)->text('Какой-то текст')->send();
echo $response;
```
выведет 
```json
{"status":"success"}
```

#### Расширение
* Другие какналы для уведомлений можно добавлять, создавая новые в текущем репозитории или же в runtime, используя следующий метод 
  ```php
  \AlexanderKotov\Notifications\Notification::registerConnector('sms', SMSConnector::class);
  ```
* У Connector есть константа EXECUTABLE, означающая что для отправки требуются дополнителные действаия. По умолчанию false. 
Так, например, для PushConnector значение false, т.к. дополнительно с пушем ничего делать не нужно. 
Для TelegramConnector значение true, т.к. уведомление необходимо отправлять. 
При запуске консольной команды, коннекторы со значением false будут проигнорированы. 
* При расширении рекомендуется наследовать Коннектор от AbstractConnector и реализовывать ConnectorInterface