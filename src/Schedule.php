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
use ElementVip\Component\Order\Models\Order;
use ElementVip\Scheduling\Schedule\Scheduling;

class Schedule extends Scheduling
{
    public function schedule()
    {
        $this->schedule->call(function () {
            $orders = Order::where('status', Order::STATUS_NEW)->where('type', Order::TYPE_GROUPON)->get();
            if (count($orders) > 0) {
                foreach ($orders as $order) {
                    if (isset($order->specialTypes()->first()->groupon_item->auto_close) and $delayTime = $order->specialTypes()->first()->groupon_item->auto_close) {
                        $delayTime = Carbon::now()->addMinute(-$delayTime);
                        if ($order->submit_time < $delayTime) {
                            $order->status = Order::STATUS_CANCEL;
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
