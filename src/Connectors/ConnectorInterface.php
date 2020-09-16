<?php


namespace AlexanderKotov\Notifications\Connectors;


use AlexanderKotov\Notifications\Response;
use Carbon\Carbon;

interface ConnectorInterface
{
    public function setConfig(?array $data);

    public function send():Response;

    public function date(Carbon $date);

    public function getData():array;
}
