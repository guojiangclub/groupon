<?php

/*
 * This file is part of ibrand/groupon.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Component\Groupon\Models;

use Carbon\Carbon;
use ElementVip\Component\Product\Models\Goods;
use Illuminate\Database\Eloquent\Model;

class GrouponItem extends Model
{
    const ING = 1;        //进行中
    const UNING = 2;      //未开始
    const INGED = 3;      //已过期
    const CHANCE = 4;       //秒杀团参与人数已满待成团
    const SUCCESS = 5;      //已成团秒杀团结束

    protected $table = 'el_groupon_item';

    protected $guarded = ['id'];

    protected $appends = ['starts_at', 'ends_at', 'init_status', 'is_end', 'auto_close', 'server_time', 'sale_number', 'surplus_number', 'order_number'];

    public function groupon()
    {
        return $this->belongsTo(Groupon::class);
    }

    public function goods()
    {
        return $this->belongsTo(config('ibrand.groupon.models.goods'));
    }

    public function SpecialType()
    {
        return $this->hasMany(config('ibrand.groupon.models.order_special_type'), 'origin_id', 'id');
    }

    public function sale()
    {
        return $this->hasMany(GrouponSale::class, 'groupon_item_id', 'id');
    }

    public function getSaleNumberAttribute()
    {
        if (isset($this->sale) and $this->sale->sum('quantity')) {
            return $this->sale->sum('quantity');
        }

        return 0;
    }

    public function getSurplusNumberAttribute()
    {
        $num = $this->number - $this->sale_number;
        if ($num <= 0) {
            return 0;
        }

        return $num;
    }

    public function getStartsAtAttribute()
    {
        if (isset($this->groupon->starts_at)) {
            return $this->groupon->starts_at;
        }

        return '';
    }

    public function getOrderNumberAttribute()
    {
        $order_list = $this->SpecialType->filter(function ($item) {
            if (0 != $item->order_status) {
                return $item;
            }
        });

        return count($order_list);
    }

    public function getServerTimeAttribute()
    {
        return date('Y-m-d H:i:s', Carbon::now()->timestamp);
    }

    public function getAutoCloseAttribute()
    {
        if (isset($this->groupon->auto_close)) {
            return $this->groupon->auto_close;
        }

        return 0;
    }

    public function getIsEndAttribute()
    {
        if (2 == $this->status) {
            return true;
        }

        if (Carbon::now() >= $this->groupon->starts_at and Carbon::now() <= $this->groupon->ends_at) {
            return false;
        } elseif (Carbon::now() < $this->groupon->starts_at) {
            return false;
        }

        return true;
    }

    public function getEndsAtAttribute()
    {
        if (isset($this->groupon->ends_at)) {
            return $this->groupon->ends_at;
        }

        return '';
    }

    public function getInitStatusAttribute()
    {
        if (Carbon::now() >= $this->groupon->starts_at and Carbon::now() <= $this->groupon->ends_at) {
            if ($this->number <= $this->order_number) {
                return self::CHANCE;
            }

            return self::ING;
        } elseif (Carbon::now() < $this->groupon->starts_at) {
            return self::UNING;
        } elseif (2 == $this->status) {
            return self::SUCCESS;
        }

        return self::INGED;
    }
}
