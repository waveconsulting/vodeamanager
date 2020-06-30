<?php

namespace Vodeamanager\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    protected $lazyLoadingRelationAccount = [];

    public function account(Request $request)
    {
        $data = config('vodeamanager.models.user')::with($this->lazyLoadingRelationAccount)->findOrFail(Auth::id());

        $resource = $data->getResource();

        return new $resource($data);
    }

    public function permission(Request $request)
    {
        $data = config('vodeamanager.models.user')::findOrFail(Auth::id());

        return response()->json([
            'data' => $data->permissions
        ], 200);
    }

    public function revoke(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'success' => true,
        ], 200);
    }
}
