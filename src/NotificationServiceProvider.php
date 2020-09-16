<?php


namespace AlexanderKotov\Notifications;

use AlexanderKotov\Notifications\Commands\NotificationCommand;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([__DIR__ . '/config/notifications.php' => config_path('notifications.php')]);
        $this->publishes([realpath(__DIR__ . '/migrations') => $this->app->databasePath() . '/migrations']);
        $this->commands([NotificationCommand::class]);
    }
}