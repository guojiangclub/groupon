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
use Prettus\Repository\Eloquent\BaseRepository;

class GrouponRepository extends BaseRepository
{
    const OPEN = 1;
    const CLOSE = 0;

    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return Groupon::class;
    }

    /**
     * 通过团购活动ID获取进行中有效团购信息.
     *
     * @param $id
     *
     * @return array
     */
    public function getGrouponById($id)
    {
        return $this->model->where('ends_at', '>=', Carbon::now())
            ->where('starts_at', '<=', Carbon::now())
            ->where('status', self::OPEN)
            ->with('items.goods')
            ->whereHas('items', function ($query) use ($id){
               return $query->where('groupon_id', $id)->where('status', self::OPEN)->orderBy('id', 'desc');
            })->first();
    }

    /**
     * 获取全部进行中有效团购信息.
     *
     * @return array
     */
    public function getGrouponAll()
    {
        return $this->model
            ->orderBy('starts_at', 'asc')
            ->where('ends_at', '>=', Carbon::now())
            ->where('starts_at', '<=', Carbon::now())
            ->where('status', self::OPEN)
            ->with('items.goods')
            ->with(['items' => function ($query) {
                $query->where('status', self::OPEN)->orderBy('id', 'desc');
            }])
            ->whereHas('items', function ($query) {
                return $query;
            })->get();
    }
}
