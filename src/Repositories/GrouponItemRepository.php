<?php

/*
 * This file is part of ibrand/groupon.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Component\Groupon\Repositories;

use Carbon\Carbon;
use iBrand\Component\Groupon\Models\Groupon;
use iBrand\Component\Groupon\Models\GrouponItem;
use iBrand\Component\Groupon\Models\GrouponSale;
use Prettus\Repository\Eloquent\BaseRepository;

class GrouponItemRepository extends BaseRepository
{
    const OPEN = 1;
    const CLOSE = 0;
    const END = 2;

    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return GrouponItem::class;
    }


    /**
     * 获取全部未过期的有效拼团活动列表.
     *
     * @param $limit
     *
     * @return mixed
     */
    public function getGrouponItemAll($limit)
    {
        return $this->model
            ->where('status', self::OPEN)
            ->with(['groupon' => function ($query) {
                $query->where('status', self::OPEN);
            }])
            ->whereHas('groupon', function ($query) {
                return $query->where('status', self::OPEN)->where('ends_at', '>=', Carbon::now());
            })
            ->with(['SpecialType' => function ($query) {
                return $query->where('origin_type', 'groupon_item')->with('order');
            }])
            ->with('goods')
            ->orderBy('sort', 'desc')
            ->paginate($limit);
    }


    /**
     * get all active groupon items.
     * @param $limit
     */
    public function findActive($limit)
    {
        return $this->model
            ->where('status', self::OPEN)
            ->with(['groupon' => function ($query) {
                $query->where('status', self::OPEN);
            }])
            ->whereHas('groupon', function ($query) {
                return $query->where('status', self::OPEN)->where('ends_at', '>=', Carbon::now());
            })
            /*->with(['SpecialType' => function ($query) {
                return $query->where('origin_type', 'groupon_item')->with('order');
            }])*/
            ->with('goods')
            ->orderBy('sort', 'desc')
            ->paginate($limit);
    }

    /**
     * get active item by item's id.
     * @param $id
     * @return mixed
     */
    public function findActiveById($id)
    {
        return $this->model
            ->where('id', $id)
            ->where('status', self::OPEN)
            ->whereHas('groupon', function ($query) {
                return $query->where('status', self::OPEN)->where('ends_at', '>=', Carbon::now())
                    ->where('starts_at', '<=', Carbon::now());
            })
            ->first();
    }

    /**
     * * 获取GoodsID获取有效拼团活动信息.
     *
     * @param $goods_id
     *
     * @return mixed
     */
    public function getGrouponItemByGoodsID($goods_id)
    {
        return $this->model
            ->where('status', self::OPEN)
            ->where('goods_id', $goods_id)
            ->with(['groupon' => function ($query) {
                $query->where('status', self::OPEN);
            }])
            ->with(['SpecialType' => function ($query) {
                return $query->where('origin_type', 'groupon_item')->with('order');
            }])
            ->whereHas('groupon', function ($query) {
                return $query->where('status', self::OPEN)->where('ends_at', '>=', Carbon::now());
            })
            ->first();
    }

    /**
     * 根据goods_id获取进行中的拼团活动.
     *
     * @param $goods_id
     *
     * @return mixed
     */
    public function getHavingGrouponByGoodsID($goods_id)
    {
        return $this->model
            ->where('status', self::OPEN)
            ->where('goods_id', $goods_id)
            ->whereHas('groupon', function ($query) {
                return $query->where('status', self::OPEN)->where('ends_at', '>=', Carbon::now())->where('starts_at', '<=', Carbon::now());
            })
            ->first();
    }

    /**
     * * 获取ID获取进行中的拼团活动信息.
     *
     * @param $id
     *
     * @return mixed
     */
    public function getGrouponItemByID($id)
    {
        return $this->model
            ->where('status', self::OPEN)
            ->where('id', $id)
            ->with(['groupon' => function ($query) {
                $query->where('status', self::OPEN);
            }])
            ->whereHas('groupon', function ($query) {
                return $query->where('status', self::OPEN)->where('ends_at', '>=', Carbon::now())->where('starts_at', '<=', Carbon::now());
            })
            ->first();
    }

    public function CheckGrouponItemInfo($id, $groupon_price, $goods_id)
    {
        return $this->model
            ->where('status', self::OPEN)
            ->where('id', $id)
            ->where('goods_id', $goods_id)
            ->where('groupon_price', $groupon_price)
            ->with(['SpecialType' => function ($query) {
                return $query->where('origin_type', 'groupon_item')->with('order');
            }])
            ->with(['groupon' => function ($query) {
                $query->where('status', self::OPEN);
            }])
            ->whereHas('groupon', function ($query) {
                return $query->where('status', self::OPEN)->where('ends_at', '>=', Carbon::now())->where('starts_at', '<=', Carbon::now());
            })
            ->first();
    }

    public function getUserGrouponGoodsCountByItemId($groupon_item_id, $user_id)
    {
        if ($groupon_sale = GrouponSale::where('user_id', $user_id)->where('groupon_item_id', $groupon_item_id)->first()) {
            return $groupon_sale->quantity;
        }

        return 0;
    }

    /**
     * 获取第一条拼团数据.
     *
     * @return mixed
     */
    public function getGrouponItemFirst()
    {
        return $this->model
            ->where('status', self::OPEN)
            ->with(['groupon' => function ($query) {
                $query->where('status', self::OPEN);
            }])
            ->whereHas('groupon', function ($query) {
                return $query->where('status', self::OPEN)->where('ends_at', '>=', Carbon::now());
            })
            ->with(['SpecialType' => function ($query) {
                return $query->where('origin_type', 'groupon_item')->with('order');
            }])
            ->with('goods')
            ->orderBy('sort', 'desc')
            ->first();
    }
}
