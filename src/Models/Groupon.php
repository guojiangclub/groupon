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

class Groupon extends Model
{
    protected $table = 'el_groupon';

    protected $guarded = ['id'];

    protected $appends = ['tag'];

    public function items()
    {
        return $this->hasMany(GrouponItem::class);
    }

    public function getTagAttribute()
    {
        if (!empty($this->tags)) {
            return  $res = explode(',', $this->tags);
        }

        return '';
    }
}
