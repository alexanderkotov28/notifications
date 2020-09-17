<?php


namespace AlexanderKotov\Notifications\Connectors;


use AlexanderKotov\Notifications\NotificationModel;
use Carbon\Carbon;

class AbstractConnector
{
    protected $model;

    public function setModel(NotificationModel $model)
    {
        $this->model = $model;
    }

    protected function setExecuted()
    {
        if ($this->model){
            $this->model->update(['executed_at' => Carbon::now()]);
        }
    }
}