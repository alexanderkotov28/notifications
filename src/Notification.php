<?php


namespace AlexanderKotov\Notifications;


use AlexanderKotov\Notifications\Connectors\ConnectorInterface;
use AlexanderKotov\Notifications\Connectors\EmailConnector;
use AlexanderKotov\Notifications\Connectors\PushConnector;
use AlexanderKotov\Notifications\Connectors\TelegramConnector;
use Illuminate\Support\Facades\Config;

class Notification
{
    private static $connectors = [
        'telegram' => TelegramConnector::class,
        'email' => EmailConnector::class,
        'push' => PushConnector::class
    ];

    /**
     * Notification constructor is disabled.
     */
    private function __construct()
    {
    }

    public static function __callStatic($name, $arguments): ConnectorInterface
    {
        $class = self::getConnectorClass($name);
        $connector = new $class(...$arguments);
        $connector->setConfig(Config::get('notifications.' . $name));
        return $connector;
    }

    public static function registerConnector(string $connector, string $name)
    {
        static::$connectors[$name] = $connector;
    }

    public static function connectorFromModel(NotificationModel $model)
    {
        $class = self::getConnectorClass($model->connector);
        $connector = $class::generateFromData($model->data);
        $connector->setConfig(Config::get('notifications.' . $model->connector));
        $connector->setModel($model);
        return $connector;
    }

    private static function getConnectorClass(string $connector): string
    {
        if (!isset(static::$connectors[$connector])) {
            throw new \Exception('Undefined connector "' . $connector . '"');
        }

        if (!class_exists(static::$connectors[$connector])) {
            throw new \Exception(sprintf('Class "%s"not found for connector "%s"', static::$connectors[$connector], $connector));
        }
        return static::$connectors[$connector];
    }


}
