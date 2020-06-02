<?php

namespace Vodeamanager\Core\Http\Controllers;

use Vodeamanager\Core\Entities\Notification;
use Vodeamanager\Core\Http\Resources\NotificationResource;
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
}