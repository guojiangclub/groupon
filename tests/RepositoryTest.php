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

//use Mockery;

class RepositoryTest extends BaseTest
{
    public function testGrouponItemRepository()
    {
        //test null groupon
        $groupon = $this->grouponRepository->getGrouponById(1);

        $this->assertNull($groupon);

        //test create groupon
        $attr_groupon = ['title' => 'test1', 'status' => 1, 'auto_close' => 0, 'starts_at' => '2018-01-26 10:49:00', 'ends_at' => '2050-02-30 10:49:00'];

        $attr_groupon_status_0 = ['title' => 'test1', 'status' => 0, 'auto_close' => 0, 'starts_at' => '2018-01-26 10:49:00', 'ends_at' => '2050-02-30 10:49:00'];

        $attr_groupon_ends_at = ['title' => 'test1', 'status' => 1, 'auto_close' => 0, 'starts_at' => '2018-01-26 10:49:00', 'ends_at' => '2018-01-26 10:49:00'];

        $res_groupon_frist = $this->grouponRepository->create($attr_groupon);

        $this->grouponRepository->create($attr_groupon_status_0);

        $this->grouponRepository->create($attr_groupon_ends_at);

        $attr_groupon_all=$this->grouponRepository->all();

        $this->assertSame('iBrand\Component\Groupon\Models\Groupon', get_class($res_groupon_frist));

        $this->assertSame(1, $res_groupon_frist->id);

        $this->assertSame(3,$attr_groupon_all->count());


        //test create groupon_item
        $attr_groupon_item = ['groupon_id' => 1, 'goods_id' => 1, 'number' => 2, 'manx_number' => 10, 'groupon_price' => '100.00', 'status' => 1];

        $res_groupon_item = $this->grouponItemRepository->create($attr_groupon_item);

        $this->assertSame('iBrand\Component\Groupon\Models\GrouponItem', get_class($res_groupon_item));

        $this->assertSame(1, $res_groupon_item->id);

        //test groupon_item getGrouponItemAll
        $res_groupon_item_all = $this->grouponItemRepository->getGrouponItemAll(10);

        $this->assertSame(1,$res_groupon_item_all->count());


        //test groupon_item getGrouponItemByGoodsID

        $attr_groupon = ['title' => 'test1', 'status' => 1, 'auto_close' => 0, 'starts_at' => '2020-01-26 10:49:00', 'ends_at' => '2050-01-26 10:49:00'];

        $res_groupon = $this->grouponRepository->create($attr_groupon);

        $attr_groupon_item = ['groupon_id' => 1, 'goods_id' => 1, 'number' => 2, 'manx_number' => 10, 'groupon_price' => '100.00', 'status' => 1];

        $res_groupon_item = $this->grouponItemRepository->create($attr_groupon_item);

        $attr_groupon_item = ['groupon_id' => 2, 'goods_id' => 2, 'number' => 2, 'manx_number' => 10, 'groupon_price' => '200.00', 'status' => 1];

        $res_groupon_item = $this->grouponItemRepository->create($attr_groupon_item);

        $attr_groupon_item = ['groupon_id' => 2, 'goods_id' => 3, 'number' => 2, 'manx_number' => 10, 'groupon_price' => '300.00', 'status' => 1];

        $res_groupon_item = $this->grouponItemRepository->create($attr_groupon_item);

        $attr_groupon_item = ['groupon_id' => 4, 'goods_id' => 4, 'number' => 2, 'manx_number' => 10, 'groupon_price' => '400.00', 'status' => 1];

        $res_groupon_item = $this->grouponItemRepository->create($attr_groupon_item);


        $res_groupon_item_goods = $this->grouponItemRepository->getGrouponItemByGoodsID(1);

        $this->assertSame('iBrand\Component\Groupon\Models\GrouponItem', get_class( $res_groupon_item_goods));

        $this->assertSame(1,$res_groupon_item_goods->goods->id );

        $this->assertNull($this->grouponItemRepository->getGrouponItemByGoodsID(2) );

        $this->assertNull($this->grouponItemRepository->getGrouponItemByGoodsID(3) );

        $this->assertSame('iBrand\Component\Groupon\Models\GrouponItem', get_class( $this->grouponItemRepository->getGrouponItemByGoodsID(4)));


        //test groupon_item getHavingGrouponByGoodsID

        $this->assertSame('iBrand\Component\Groupon\Models\GrouponItem', get_class($this->grouponItemRepository->getHavingGrouponByGoodsID(1)));

        $this->assertNull($this->grouponItemRepository->getHavingGrouponByGoodsID(4));

        $this->assertNull( $this->grouponItemRepository->getHavingGrouponByGoodsID(2));

        $this->assertNull( $this->grouponItemRepository->getHavingGrouponByGoodsID(3));


        //test groupon_item getGrouponItemByID

        $getGrouponItemByID=$this->grouponItemRepository->getGrouponItemByID(1);

        $this->assertSame('iBrand\Component\Groupon\Models\GrouponItem', get_class($getGrouponItemByID));

        $this->assertSame(1, $getGrouponItemByID->id);

        $this->assertNull($this->grouponItemRepository->getGrouponItemByID(3));

        $this->assertNull($this->grouponItemRepository->getGrouponItemByID(4));

        //test groupon_item CheckGrouponItemInfo

        $this->assertNull($this->grouponItemRepository->CheckGrouponItemInfo(2,100,2));

        $this->assertSame('iBrand\Component\Groupon\Models\GrouponItem', get_class($this->grouponItemRepository->CheckGrouponItemInfo(1,100,1)));


        //test groupon_item getUserGrouponGoodsCountByItemId
        $this->assertSame(0,$this->grouponItemRepository->getUserGrouponGoodsCountByItemId(1,1));

        $groupon_sale=\iBrand\Component\Groupon\Models\GrouponSale::create(['user_id'=>1,'groupon_item_id'=>1,'quantity'=>1]);

        $this->assertEquals(1,$this->grouponItemRepository->getUserGrouponGoodsCountByItemId(1,1));


        //test groupon_item getGrouponItemFirst

        $this->assertSame('iBrand\Component\Groupon\Models\GrouponItem',get_class( $this->grouponItemRepository->getGrouponItemFirst()));

        $attr_groupon = ['title' => 'testNew', 'status' => 1, 'auto_close' => 0, 'starts_at' => '2018-01-26 10:49:00', 'ends_at' => '2050-02-30 10:49:00'];

        $attr_groupon_res_last=$this->grouponRepository->create($attr_groupon);

        $this->assertSame('iBrand\Component\Groupon\Models\Groupon',get_class($attr_groupon_res_last));

        $attr_groupon_item = ['groupon_id' => $attr_groupon_res_last->id, 'goods_id' => 4, 'number' => 2, 'manx_number' => 10, 'groupon_price' => '888.00', 'status' => 1,'sort'=>99];

        $attr_groupon_item_res=$this->grouponItemRepository->create($attr_groupon_item);

        $getGrouponItemFirst=$this->grouponItemRepository->getGrouponItemFirst();

        $this->assertSame('iBrand\Component\Groupon\Models\GrouponItem',get_class($getGrouponItemFirst));

        $this->assertSame($attr_groupon_item_res->id,$getGrouponItemFirst->id);

        //test groupon testGrouponRepository
        $attr_groupon_res=$this->grouponRepository->getGrouponAll();

        $this->assertSame(2,$attr_groupon_res->count());

        $this->assertSame($res_groupon_frist->id,$attr_groupon_res->first()->id);

        $this->assertSame($attr_groupon_res_last->id,$attr_groupon_res->last()->id);


    }









}
