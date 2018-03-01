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


use \Carbon\Carbon;

//use Mockery;

class GrouponServiceTest extends BaseTest
{

        public function testMakeCartItems(){
            $buys=[];
            $empty_buys=$this->GrouponService->makeCartItems($buys);
            $this->assertSame([],$empty_buys);
            $sku_buys=[
                'id' =>1,
                'qty'=>1,
                'name'=>'test',
                'img'=>'XXX',
                'price'=>1,
                'total'=>1,
                'attributes'=>[
                    'dynamic_sku'=>[
                        'id'=>1,
                        'size'=>"S",
                        'color'=>"白",
                    ],
                ],
                'groupon_goods_id'=>1,
                'groupon_item_id'=>1
            ];

            $sku_buys_res=$this->GrouponService->makeCartItems($sku_buys);

            $this->assertSame('iBrand\Shoppingcart\Item',get_class($sku_buys_res->first()));

            $this->assertSame('ElementVip\Component\Product\Models\Product',$sku_buys_res->first()->__model);

            $this->assertSame('sku',$sku_buys_res->first()->type);

            $sku_buys=[
                'id' =>1,
                'qty'=>1,
                'name'=>'test',
                'img'=>'XXX',
                'price'=>1,
                'total'=>1,
                'groupon_goods_id'=>1,
                'groupon_item_id'=>1
            ];

            $sku_buys_res=$this->GrouponService->makeCartItems($sku_buys);

            $this->assertSame('iBrand\Shoppingcart\Item',get_class($sku_buys_res->first()));

            $this->assertSame('ElementVip\Component\Product\Models\Goods',$sku_buys_res->first()->__model);

            $this->assertSame('spu',$sku_buys_res->first()->type);

        }








}
