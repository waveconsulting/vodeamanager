<?php

namespace Vodea\Vodeamanager\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Vodea\Vodeamanager\Http\Resources\SelectResource;

trait VodeaController
{
    protected $repository;
    protected $validator;
    protected $resource;
    protected $selectResource;
    protected $view;
    protected $page;

    public function index(Request $request) {
        if (empty($request->per_page)) {
            $data = $this->repository->all();
        } else {
            $data = $this->repository->paginate($request->per_page);
        }

        if ($this->resource instanceof JsonResource) {
            return $this->resource::collection($data);
        }

        return $data;
    }

    public function select(Request $request) {
        if (empty($request->per_page)) {
            $data = $this->repository->all();
        } else {
            $data = $this->repository->paginate($request->per_page);
        }

        if ($this->selectResource instanceof JsonResource) {
            return $this->selectResource::collection($data);
        }

        return SelectResource::collection($data);
    }

    public function show(Request $request, $id) {
        $data = $this->repository->find($id);

        if ($this->resource instanceof JsonResource) {
            return new $this->resource($data);
        }

        return $data;
    }

    public function destroy(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $this->repository->findOrFail($id);

            $this->repository->destroy($id);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data deleted.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error'   => true,
                'message' => $e->getMessage()
            ]);
        }
    }
}
