<?php


namespace AlexanderKotov\Notifications\Connectors;


use AlexanderKotov\Notifications\NotificationModel;
use Carbon\Carbon;

class AbstractConnector
{
    protected $model;
    protected $user_id;
    protected $not_empty = [];

    const EXECUTABLE = false;

    public function executable()
    {
        return static::EXECUTABLE;
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
            $this->model->setExecuted();
        }
    }

    protected function validate()
    {
        foreach ($this->not_empty as $property) {
            if (empty($this->{$property})){
                throw new \Exception(sprintf('Property "%s" is required for "%s"', $property, static::class));
            }
        }
    }
}