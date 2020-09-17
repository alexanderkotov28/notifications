<?php


namespace AlexanderKotov\Notifications\Connectors;


use AlexanderKotov\Notifications\NotificationModel;
use Carbon\Carbon;

class AbstractConnector
{
    protected $model;
    protected $user_id;

    const EXECUTABLE = false;

    public function executable()
    {
        return self::EXECUTABLE;
    }

    public function setModel(NotificationModel $model)
    {
        $this->model = $model;
    }

    protected function setUser($user_id)
    {
        $this->user_id = $user_id;
    }

    protected function createModel(string $connector_name, Carbon $date, array $data)
    {
        NotificationModel::create([
            'connector' => $connector_name,
            'execute_at' => $date,
            'data' => $data,
            'user_id' => $this->user_id
        ]);
    }

    protected function setExecuted()
    {
        if ($this->model) {
            $this->model->update(['executed_at' => Carbon::now()]);
        }
    }
}