<?php

namespace AlexanderKotov\Notifications\Commands;

use AlexanderKotov\Notifications\Notification;
use AlexanderKotov\Notifications\NotificationModel;
use Carbon\Carbon;
use Illuminate\Console\Command;

class NotificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send recent notifications';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $notifications = NotificationModel::where(
            [
                ['execute_at', '<', Carbon::now()],
                ['executed_at', null]
            ]
        )->get();

        foreach ($notifications as $notification){
//            $b = Notification::{$notification->connector}()->setData($notification->data);
            $b = Notification::generateConnector($notification->connector, $notification->data);
            dd($b);
        }

        dd($notifications);
    }
}