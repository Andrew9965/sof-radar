<?php

namespace App\Http\Resources;

use App\Models\Traits\ChartSorterTrait;
use Illuminate\Http\Resources\Json\Resource;


class Chart extends Resource
{
    use ChartSorterTrait;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
