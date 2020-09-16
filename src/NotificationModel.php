<?php


namespace AlexanderKotov\Notifications;


use Illuminate\Database\Eloquent\Model;

class NotificationModel extends Model
{
    protected $guarded = [];
    protected $table = 'notifications';
    protected $casts = [
        'data' => 'array'
    ];
}
