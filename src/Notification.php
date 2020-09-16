<?php


namespace AlexanderKotov\Notifications;


use App\Helpers\Notification\Connectors\ConnectorInterface;
use App\Helpers\Notification\Connectors\EmailConnector;
use App\Helpers\Notification\Connectors\TelegramConnector;
use Illuminate\Support\Facades\Config;

class Notification
{
    private static $connectors = [
        'telegram' => TelegramConnector::class,
        'email' => EmailConnector::class
    ];

    /**
     * Notification constructor is disabled.
     */
    private function __construct()
    {
    }

    public static function __callStatic($name, $arguments): ConnectorInterface
    {
        if (!isset(static::$connectors[$name])) {
            throw new \Exception('Undefined connector "' . $name . '"');
        }

        if (!class_exists(static::$connectors[$name])) {
            throw new \Exception(sprintf('Class "%s"not found for connector "%s"', static::$connectors[$name], $name));
        }

        $connector = new static::$connectors[$name](...$arguments);
        $connector->setConfig(Config::get('notifications.' . $name));
        return $connector;
    }

    public static function registerConnector(string $connector, string $name)
    {
        static::$connectors[$name] = $connector;
    }
}
