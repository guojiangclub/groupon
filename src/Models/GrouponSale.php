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

use Illuminate\Database\Eloquent\Model;

class GrouponSale extends Model
{
    protected $table = 'el_groupon_sale';

    protected $guarded = ['id'];
}
