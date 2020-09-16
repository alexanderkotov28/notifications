<?php


namespace AlexanderKotov\Notifications;

use AlexanderKotov\Notifications\Commands\NotificationCommand;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->publishes([__DIR__.'/config/notifications.php' => config_path('notifications.php')]);
        if ($this->app->runningInConsole()) {
            $this->commands([
                NotificationCommand::class,
            ]);
        }
    }
}