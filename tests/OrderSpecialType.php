<?php

/*
 * This file is part of ibrand/groupon.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Component\Groupon\Test;

use Illuminate\Database\Eloquent\Model;

class OrderSpecialType extends Model
{
    protected $table = 'el_order_special_type';

    protected $guarded = ['id'];

    protected $appends = ['order_status'];

    public function grouponItem()
    {
        return $this->belongsTo(\iBrand\Component\Groupon\Models\GrouponItem::class, 'origin_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function getOrderStatusAttribute()
    {
        return $this->order->status;
    }
}
