<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Carbon\Carbon;

/**
 * Class NotificationController
 */
class NotificationController extends AppBaseController
{
    /**
     * @return mixed
     */
    public function readNotification(Notification $notification)
    {
        $notification->read_at = Carbon::now();
        $notification->save();

        return $this->sendSuccess(__('messages.flash.notification_read'));
    }

    /**
     * @return mixed
     */
    public function readAllNotification()
    {
        Notification::whereReadAt(null)->where('user_id', getLoggedInUserId())->update(['read_at' => Carbon::now()]);

        return $this->sendSuccess(__('messages.flash.all_notification_read'));
    }
}
