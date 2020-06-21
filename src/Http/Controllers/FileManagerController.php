<?php

namespace Vodeamanager\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Vodeamanager\Core\Entities\FileLog;
use Vodeamanager\Core\Http\Requests\FileLogCreateRequest;
use Vodeamanager\Core\Http\Resources\FileLogResource;
use Vodeamanager\Core\Utilities\Facades\ExceptionService;
use Vodeamanager\Core\Utilities\Facades\FileService;
use Vodeamanager\Core\Utilities\Traits\RestCoreController;

class FileManagerController extends Controller
{
    use RestCoreController {
        RestCoreController::__construct as private __restConstruct;
    }

    public function __construct(FileLog $repository)
    {
        $this->repository = $repository;
        $this->__restConstruct();
    }

    public function store(FileLogCreateRequest $request)
    {
        try {
            DB::beginTransaction();

            $merge = [];

            $uploads = FileService::store($request, 'file', $request->get('disk'), $request->get('path'));
            foreach ($uploads as $name => $file) {
                $merge['name'] = $file->name;
                $merge['encoded_name'] = $file->encoded_name;
                $merge['size'] = $file->size;
                $merge['extension'] = $file->extension;
                $merge['path'] = $file->path;
                $merge['disk'] = $file->disk;
            }

            $request->merge($merge);

            $data = $this->repository->create($request->only($this->fillable));

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

    public function download(Request $request, $id) {
        $fileLog = $this->repository->findOrFail($id);

        $disk = Storage::disk($fileLog->disk);
        if (!(clone $disk)->exists($fileLog->path)) {
            return abort(404);
        }

        return $disk->download($fileLog->path);
    }
}
