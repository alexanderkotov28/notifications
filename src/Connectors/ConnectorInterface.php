<?php


namespace AlexanderKotov\Notifications\Connectors;


use AlexanderKotov\Notifications\NotificationModel;
use AlexanderKotov\Notifications\Response;
use Carbon\Carbon;

interface ConnectorInterface
{
    /**
     * Установка данных из конфига config/notifications.php
     * @param array|null $data
     * @return mixed
     */
    public function setConfig(?array $data);

    /**
     * Отправка уведомления
     * @return Response
     */
    public function send(): Response;

    /**
     * Отправить уведомление в определённую дату
     * @param Carbon $date
     * @return mixed
     */
    public function date(Carbon $date);

    /**
     * Получение данных для уведомления, например текста, заголовка и т.п.
     * @return array
     */
    public function getData(): array;

    /**
     * Поставить в соответствие модель
     * @param NotificationModel $model
     * @return mixed
     */
    public function setModel(NotificationModel $model);

    /**
     * Создаёт коннектор и заполняет его данными из переданного массива
     * @param array $data
     * @return mixed
     */
    public static function generateFromData(array $data);
}
