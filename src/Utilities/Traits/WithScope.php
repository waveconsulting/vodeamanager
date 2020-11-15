<?php

namespace Vodeamanager\Core\Utilities\Traits;

use Illuminate\Http\Request;

trait WithScope
{
    public function scopeCriteria($query, Request $request) {
        if ($request->has('order_by')) {
            $sorted = in_array(strtolower($request->get('sorted_by')), ['desc', 'descending']) ? 'desc' : 'asc';
            $order = $request->get('order_by');

            $query->orderBy($order, $sorted);
        }
    }

    public function scopeFilter($query, Request $request)
    {
        //
    }

    public function scopeSubQueryIndex($query, Request $request)
    {
        //
    }

    public function scopeSubQuerySelect($query, Request $request)
    {
        //
    }

    public function scopeSubQueryShow($query, Request $request)
    {
        //
    }
}
