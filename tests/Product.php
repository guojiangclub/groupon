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

class Product extends Model
{
    protected $table = 'el_goods_product';

    protected $guarded = ['id'];

    public function goods()
    {
        return $this->belongsTo(Goods::class);
    }
}
