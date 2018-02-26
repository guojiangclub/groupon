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
    public function testGetGrouponById()
    {
        //test null groupon
        $groupon = $this->grouponRepository->getGrouponById(1);

        $this->assertNull($groupon);

        //test create groupon
        $attr_groupon = ['title' => 'test1', 'status' => 1, 'auto_close' => 0, 'starts_at' => '2018-01-26 10:49:00', 'ends_at' => '2050-02-30 10:49:00'];

        $res_groupon = $this->grouponRepository->create($attr_groupon);

        $this->assertSame('iBrand\Component\Groupon\Models\Groupon', get_class($res_groupon));

        $this->assertSame(1, $res_groupon->id);

        //test create groupon_item
        $attr_groupon_item = ['groupon_id' => 1, 'goods_id' => 1, 'number' => 2, 'manx_number' => 10, 'groupon_price' => '100.00', 'status' => 1];

        $res_groupon_item = $this->grouponItemRepository->create($attr_groupon_item);

        $this->assertSame('iBrand\Component\Groupon\Models\GrouponItem', get_class($res_groupon_item));

        $this->assertSame(1, $res_groupon_item->id);
    }
}
