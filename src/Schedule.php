<?php

/*
 * This file is part of ibrand/groupon.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Component\Groupon;

use Carbon\Carbon;
use iBrand\Scheduling\Scheduling;

class Schedule extends Scheduling
{
    public function schedule()
    {
        $this->schedule->call(function () {
            $orders = config('ibrand.groupon.models.order')::where('status', config('ibrand.groupon.models.order')::STATUS_NEW)->where('type', config('ibrand.groupon.models.order')::TYPE_GROUPON)->get();
            if (count($orders) > 0) {
                foreach ($orders as $order) {
                    if (isset($order->specialTypes()->first()->groupon_item->auto_close) and $delayTime = $order->specialTypes()->first()->groupon_item->auto_close) {
                        $delayTime = Carbon::now()->addMinute(-$delayTime);
                        if ($order->submit_time < $delayTime) {
                            $order->status = config('ibrand.groupon.models.order')::STATUS_CANCEL;
                            $order->completion_time = Carbon::now();
                            $order->cancel_reason = '拼团过期未付款';
                            $order->save();
                            event('order.canceled', $order->id);
                            event('agent.order.canceled', $order->id);
                        }
                    }
                }
            }
        })->everyMinute();
    }
}
