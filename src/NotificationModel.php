<?php


namespace AlexanderKotov\Notifications;


use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class NotificationModel extends Model
{
    protected $guarded = [];
    protected $table = 'notifications';
    protected $casts = [
        'data' => 'array'
    ];

    public function setExecuted()
    {
        $this->update(['executed_at'=> Carbon::now()]);
    }
}
