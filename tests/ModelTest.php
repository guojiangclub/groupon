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

use iBrand\Component\Groupon\Models\Groupon;
use iBrand\Component\Groupon\Models\GrouponItem;
use iBrand\Component\Groupon\Models\GrouponSale;
use \Carbon\Carbon;

//use Mockery;

class ModelTest extends BaseTest
{
    public function testGrouponModels()
    {
        $groupon= new Groupon();
        $this->assertSame('iBrand\Component\Groupon\Models\Groupon', get_class($groupon));
        $groupon->tags='tags1,tags2';
        $this->assertSame(['tags1','tags2'],$groupon->tag);
        $groupon->tags='';
        $this->assertSame('',$groupon->tag);
    }

    public function testGrouponItemModels(){


        $attr_groupon_item = ['groupon_id' => 1, 'goods_id' => 1, 'number' => 3, 'manx_number' => 10, 'groupon_price' => '100.00', 'status' => 1];

        $groupon_item_res=GrouponItem::create($attr_groupon_item);

        $this->assertSame('iBrand\Component\Groupon\Models\GrouponItem', get_class($groupon_item_res));

        $this->assertEquals(0,$groupon_item_res->sale_number);

        $this->assertEquals(0,$groupon_item_res->auto_close);

        $this->assertEquals('',$groupon_item_res->starts_at);

        $this->assertEquals('',$groupon_item_res->ends_at);

        $attr_groupon_sale = ['user_id' => 1, 'groupon_item_id' => 1, 'quantity' => 5];

        $groupon_sale_res=GrouponSale::create($attr_groupon_sale);

        $attr_groupon = ['title' => 'test1', 'status' => 1, 'auto_close' => 0, 'starts_at' => '2018-01-26 10:49:00', 'ends_at' => '3000-02-30 10:49:00','tags'=>'tags1,tags2'];

        $groupon_res=Groupon::create($attr_groupon);

        $this->assertSame('iBrand\Component\Groupon\Models\Groupon', get_class($groupon_res));

        $this->assertSame('iBrand\Component\Groupon\Models\GrouponSale', get_class($groupon_sale_res));


        $attr_order_special_type = ['order_id' => 1, 'origin_type' => 'groupon_item','origin_id'=>1];

        $order_special_type_res=OrderSpecialType::create($attr_order_special_type);

        $attr_order_special_type = ['order_id' => 2, 'origin_type' => 'groupon_item','origin_id'=>1];

        $order_special_type_res=OrderSpecialType::create($attr_order_special_type);

        $attr_order_special_type = ['order_id' => 3, 'origin_type' => 'groupon_item','origin_id'=>1];

        $order_special_type_res=OrderSpecialType::create($attr_order_special_type);

        $attr_order_special_type = ['order_id' => 4, 'origin_type' => 'groupon_item','origin_id'=>1];

        $order_special_type_res=OrderSpecialType::create($attr_order_special_type);

        $groupon_item_sale_res=GrouponItem::with('sale')->with('groupon')->with('SpecialType')->find($groupon_item_res->id);

        $this->assertEquals(4,$groupon_item_sale_res->order_number);

        $this->assertEquals(5,$groupon_item_sale_res->sale_number);

        $this->assertEquals(0,$groupon_item_sale_res->surplus_number);

        $this->assertEquals($groupon_item_sale_res->starts_at,$groupon_item_sale_res->groupon->starts_at);

        $this->assertEquals($groupon_item_sale_res->ends_at,$groupon_item_sale_res->groupon->ends_at);

        $this->assertEquals($groupon_item_sale_res->auto_close,$groupon_item_sale_res->groupon->auto_close);

        $this->assertEquals(Carbon::now()->timestamp, strtotime($groupon_item_sale_res->server_time));

        $this->assertEquals(false,$groupon_item_sale_res->is_end);

        $this->assertEquals(4,$groupon_item_sale_res->init_status);

         $groupon_item_sale_res->number=100;

        $this->assertEquals(1,$groupon_item_sale_res->init_status);

        $groupon_item_sale_res->groupon->starts_at='2016-7-8 00:00:00';

        $groupon_item_sale_res->groupon->ends_at='2017-7-8 00:00:00';

        $this->assertEquals(3,$groupon_item_sale_res->init_status);

        $this->assertEquals(true,$groupon_item_sale_res->is_end);

        $groupon_item_sale_res->groupon->starts_at='2050-7-8 00:00:00';

        $groupon_item_sale_res->groupon->ends_at='3000-7-8 00:00:00';

        $this->assertEquals(2,$groupon_item_sale_res->init_status);

        $this->assertEquals( false,$groupon_item_sale_res->is_end);

        $groupon_item_sale_res->status=2;

        $this->assertEquals(true,$groupon_item_sale_res->is_end);

        $this->assertEquals(5,$groupon_item_sale_res->init_status);


    }









}
