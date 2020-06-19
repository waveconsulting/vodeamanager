<?php

namespace Vodeamanager\Core\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Vodeamanager\Core\Entities\NumberSetting;
use Vodeamanager\Core\Http\Requests\NumberSettingCreateRequest;
use Vodeamanager\Core\Http\Requests\NumberSettingUpdateRequest;
use Vodeamanager\Core\Http\Resources\NumberSettingResource;
use Vodeamanager\Core\Utilities\Facades\ExceptionService;
use Vodeamanager\Core\Utilities\Traits\RestCoreController;

class NumberSettingController extends Controller
{
    use RestCoreController {
        RestCoreController::__construct as private __restConstruct;
    }

    public function __construct(NumberSetting $repository)
    {
        $this->repository = $repository;
        $this->__restConstruct();
    }

    public function store(NumberSettingCreateRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $this->repository->create($request->only($this->fillable));

            $data->numberSettingComponents()->sync($request->get('number_setting_components') ?? []);

            DB::commit();

            return ($this->show($request, $data->id))->additional([
                'success' => true,
                'message' => 'Data created.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return ExceptionService::responseJson($e);
        }
    }

    public function update(NumberSettingUpdateRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $data = $this->repository->findOrFail($id);
            $data->fill($request->only($this->fillable));
            $data->save();

            $data->numberSettingComponents()->sync($request->get('number_setting_components') ?? []);

            DB::commit();

            return ($this->show($request,$id))->additional([
                'success' => true,
                'message' => 'Data updated.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return ExceptionService::responseJson($e);
        }
    }

}
