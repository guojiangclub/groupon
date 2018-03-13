<?php

/*
 * This file is part of ibrand/groupon.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Component\Groupon\Services;

use ElementVip\Shoppingcart\Item;
use iBrand\Component\Groupon\Models\GrouponItem;
use iBrand\Component\Groupon\Repositories\GrouponItemRepository;
use Illuminate\Support\Collection;

class GrouponService
{
    private $grouponItemRepository;

    public function __construct(
        GrouponItemRepository $grouponItemRepository)
    {
        $this->grouponItemRepository = $grouponItemRepository;
    }

    /*public function checkOrderGrouponInfo($buys, $user_id)
    {
        if (!$buys || !isset($buys['id'])) {
            throw new \Exception('拼团商品数据不存在');
        }
        $goods = config('ibrand.groupon.models.product')::find($buys['id']);

        if (!$buys['groupon_goods_id'] || !isset($buys['qty']) || !$buys['total'] || !$goods || $goods->goods_id != $buys['groupon_goods_id'] || !isset($buys['price']) || !$groupon_item = $this->grouponItemRepository->CheckGrouponItemInfo($buys['groupon_item_id'], $buys['price'], $buys['groupon_goods_id'])) {
            throw new \Exception('拼团商品不存在或已结束');
        }

        if (GrouponItem::CHANCE == $groupon_item->init_status) {
            throw new \Exception('拼团参与人数已满待成团中，稍后再试还有机会哦');
        }

        //拼团判断限购
        if ($groupon_item and GrouponItem::ING == $groupon_item->init_status and $groupon_item->limit) {
            $count = $this->grouponItemRepository->getUserGrouponGoodsCountByItemId($groupon_item->id, $user_id);
            $limit = $count > $groupon_item->limit ? 0 : $groupon_item->limit - $count;
            if (!$limit) {
                $str = '商品:'.$buys['name'].'每人限购'.$groupon_item->limit.'件';
                throw new \Exception($str);
            }
        }
        if (0 != $groupon_item->limit) {
            if ($groupon_item->limit < $buys['qty']) {
                $str = '商品:'.$buys['name'].'每人限购'.$groupon_item->limit.'件';
                throw new \Exception($str);
            }
        }

        if (number_format($buys['total'], 2, '.', '') !== number_format($groupon_item->groupon_price * $buys['qty'], 2, '.', '')) {
            throw new \Exception('拼团商品价格信息有误');
        }
    }*/


    public function makeCartItems($item, GrouponItem $grouponItem)
    {
        $cartItems = new Collection();

        /* $buys_new[] = $buys;*/

        /*foreach ($buys_new as $k => $item) {*/
        $rawId = md5(time() . $item['id']);

        $input = ['__raw_id' => $rawId,
            'id' => isset($item['id']) ? $item['id'] : '',
            'price' => $grouponItem->groupon_price,
            'name' => isset($item['name']) ? $item['name'] : '',
            'qty' => isset($item['qty']) ? $item['qty'] : 0,
            'com_id' => isset($item['id']) ? $item['id'] : '',
            'img' => isset($item['img']) ? $item['img'] : '',
        ];

        if (isset($cart['attributes']) AND !isset($cart['attributes']['sku'])) {
            $input['size'] = isset($item['size']) ? $item['size'] : '';
            $input['color'] = isset($item['color']) ? $item['color'] : '';
            $input['type'] = 'spu';
            $input['__model'] = 'ElementVip\Component\Product\Models\Goods';
        } else {
            $input['size'] = isset($item['size']) ? $item['size'] : '';
            $input['color'] = isset($item['color']) ? $item['color'] : '';
            $input['type'] = 'sku';
            $input['__model'] = 'ElementVip\Component\Product\Models\Product';
        }

        $input['total'] = $input['price'] * $input['qty'];

        /*if (isset($item['attributes']['dynamic_sku'])) {
            $input['color'] = isset($item['attributes']['dynamic_sku']['color']) ? $item['attributes']['dynamic_sku']['color'] : [];
            $input['size'] = isset($item['attributes']['dynamic_sku']['size']) ? $item['attributes']['dynamic_sku']['size'] : [];
            $input['id'] = isset($item['attributes']['dynamic_sku']['id']) ? $item['attributes']['dynamic_sku']['id'] : [];
            $input['type'] = 'sku';
            $input['__model'] = 'ElementVip\Component\Product\Models\Product';
        } else {
            $input['size'] = isset($item['size']) ? $item['size'] : '';
            $input['color'] = isset($item['color']) ? $item['color'] : '';
            $input['type'] = 'spu';
            $input['__model'] = 'ElementVip\Component\Product\Models\Goods';
        }*/

        $data = new Item($input);

        $cartItems->put($rawId, $data);

        return $cartItems;
        /*}*/
    }

    public function checkGrouponItemSales(GrouponItem $grouponItem)
    {
        if ($grouponItem->sales->count() >= $grouponItem->number) {
            throw new \Exception('拼团参与人数已满');
        }
    }

    public function checkGrouponItemLimit(GrouponItem $grouponItem, $userId, $quantity)
    {
        //拼团判断限购
        if ($grouponItem and GrouponItem::ING == $grouponItem->init_status and $grouponItem->limit) {
            $count = $this->grouponItemRepository->getUserGrouponGoodsCountByItemId($grouponItem->id, $userId);
            $limit = $count > $grouponItem->limit ? 0 : $grouponItem->limit - $count;
            if (!$limit) {
                $str = '商品:' . '每人限购' . $grouponItem->limit . '件';
                throw new \Exception($str);
            }
        }
        if (0 != $grouponItem->limit) {
            if ($grouponItem->limit < $quantity) {
                $str = '商品:' . '每人限购' . $grouponItem->limit . '件';
                throw new \Exception($str);
            }
        }
    }


}
