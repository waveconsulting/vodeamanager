<?php

namespace Vodeamanager\Core\Utilities\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Vodeamanager\Core\Http\Resources\DefaultResource;
use Vodeamanager\Core\Http\Resources\SelectResource;
use Vodeamanager\Core\Utilities\Facades\ExceptionService;

trait RestCoreController
{
    protected $repository;
    protected $namespace;
    protected $fillable;
    protected $resource;
    protected $selectResource;
    protected $policy = false;

    public function __construct()
    {
        if (!$this->namespace) $this->namespace = get_class($this->repository);
        $this->fillable = app($this->namespace)->getFillable();
    }

    public function index(Request $request) {
        $repository = $request->has('search')
            ? $this->repository->search($request->get('search'), null, true)
            : $this->repository;

        $repository = $repository->criteria($request)
            ->filter($request);

        $data = $request->has('per_page')
            ? $repository->paginate($request->per_page)
            : $repository->get();

        return is_subclass_of($this->resource, JsonResource::class)
            ? $this->resource::collection($data)
            : DefaultResource::collection($data);
    }

    public function select(Request $request, $id = null) {
        if ($id || $request->has('id')) {
            $data = $this->repository->findOrFail($id ?? $request->get('id'));

            if (is_subclass_of($this->selectResource, JsonResource::class)) {
                return new $this->selectResource($data);
            }

            return new SelectResource($data);
        }

        $repository = $request->has('search')
            ? $this->repository->search($request->get('search'), null, true)
            : $this->repository;

        $repository = $repository->criteria($request);

        $data = $request->has('per_page')
            ? $repository->paginate($request->per_page)
            : $repository->get();

        if (is_subclass_of($this->selectResource, JsonResource::class)) {
            return $this->selectResource::collection($data);
        }

        return SelectResource::collection($data);
    }

    public function show(Request $request, $id) {
        $data = $this->repository->findOrFail($id);

        if ($this->policy) $this->authorize('view', $data);

        return is_subclass_of($this->resource, JsonResource::class)
            ? new $this->resource($data)
            : new DefaultResource($data);
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $data = $this->repository->findOrFail($id);

            if ($this->policy) $this->authorize('delete', $data);

            $this->repository->destroy($id);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data deleted.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            ExceptionService::log($e);

            return response()->json([
                'error'   => true,
                'message' => $e->getMessage()
            ]);
        }
    }
}
