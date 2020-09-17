<?php

namespace AlexanderKotov\Notifications\Traits;

use AlexanderKotov\Notifications\NotificationModel;

trait Push
{
    public function pushes()
    {
        return $this->hasMany(NotificationModel::class, 'user_id', 'id')->where('connector', 'push');
    }

    public function recentPushes()
    {
        return $this->hasMany(NotificationModel::class, 'user_id', 'id')->where([['connector', 'push'], ['executed_at', null]]);
    }
}
