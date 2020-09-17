<?php

namespace AlexanderKotov\Notifications\Traits;

use AlexanderKotov\Notifications\Notification;
use AlexanderKotov\Notifications\NotificationModel;
use Carbon\Carbon;

trait Push
{
    /**
     * Все пуши пользователя
     * @return mixed
     */
    public function pushes()
    {
        return $this->hasMany(NotificationModel::class, 'user_id', 'id')->where('connector', 'push');
    }

    /**
     * Непросмотренные пуши пользователя
     * @return mixed
     */
    public function recentPushes()
    {
        return $this->hasMany(NotificationModel::class, 'user_id', 'id')->where(
            [
                ['connector', 'push'],
                ['executed_at', null],
                ['execute_at', '<', Carbon::now()]
            ]
        );
    }

    public function notificationPush(string $text, ?Carbon $date = null)
    {
        $connector = Notification::push($this->id)->text($text);
        if (is_null($date)){
            $connector->send();
        } else{
            $connector->date($date);
        }
    }
}
