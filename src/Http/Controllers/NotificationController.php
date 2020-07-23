<?php

namespace Vodeamanager\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Vodeamanager\Core\Http\Resources\DefaultResource;
use Vodeamanager\Core\Utilities\Facades\ExceptionService;
use Vodeamanager\Core\Utilities\Facades\ResourceService;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $data = [];
        if (Auth::check()) {
            $repository = Auth::user()->notifications()
                ->with('notifiable')
                ->orderByDesc('notifications.created_at');

            if ($request->get('type') == 'read') {
                $repository = $repository->whereNotNull('read_at');
            } else if ($request->get('type') == 'unread') {
                $repository = $repository->whereNull('read_at');
            }

            $data = $request->has('per_page')
                ? $repository->paginate($request->get('per_page'))
                : $repository->get();
        }

        return ResourceService::jsonCollection(DefaultResource::class,$data);
    }

    public function show(Request $Request, $id) {
        $data = null;

        if (Auth::check()) {
            $data = Auth::user()->notifications()
                ->with('notifiable')
                ->findOrFail($id);

            $data->markAsRead();
        }

        return ResourceService::jsonResource(DefaultResource::class,$data);
    }

    public function readAll(Request $request)
    {
        try {
            DB::beginTransaction();

            if (Auth::check()) {
                Auth::user()->unreadNotifications->markAsRead();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Notification updated.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return ExceptionService::responseJson($e);
        }
    }

}
