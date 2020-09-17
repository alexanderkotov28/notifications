<?php


namespace AlexanderKotov\Notifications\Connectors;


use AlexanderKotov\Notifications\NotificationModel;
use AlexanderKotov\Notifications\Response;
use Carbon\Carbon;

interface ConnectorInterface
{
    public function setConfig(?array $data);

    public function send(): Response;

    public function date(Carbon $date);

    public function getData(): array;

    public function setModel(NotificationModel $model);

    public static function generateFromData(array $data);
}
