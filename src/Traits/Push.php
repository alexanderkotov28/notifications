<?php

namespace AlexanderKotov\Notifications\Traits;

use AlexanderKotov\Notifications\Notification;
use AlexanderKotov\Notifications\NotificationModel;

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

    public function notificationPush(string $text, ?Carbon $date)
    {
        $connector = Notification::push($this->id)->text($text);
        if ($date){
            $connector->send();
        } else{
            $connector->date($date);
        }
    }
}
