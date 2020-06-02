<?php

namespace Vodeamanager\Core\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Vodeamanager\Core\Entities\Notification;
use Vodeamanager\Core\Entities\NotificationUser;
use Vodeamanager\Core\Http\Requests\FileLogCreateRequest;
use Vodeamanager\Core\Http\Resources\NotificationResource;
use Vodeamanager\Core\Utilities\Facades\ExceptionService;
use Vodeamanager\Core\Utilities\Traits\RestCoreController;

class NotificationController extends Controller
{
    use RestCoreController {
        RestCoreController::__construct as private __restConstruct;
    }

    public function __construct(Notification $repository)
    {
        $this->repository = $repository;
        $this->resource = NotificationResource::class;

        $this->__restConstruct();
    }

    public function readAll(FileLogCreateRequest $request) {
        try {
            DB::beginTransaction();

            $notificationUsers = NotificationUser::notRead()->get();
            foreach ($notificationUsers as $notificationUser) {
                $notificationUser->is_read = 1;
                $notificationUser->save();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Notification updated.'
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return ExceptionService::responseJson($e);
        }
    }

}