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
    protected $indexResource;
    protected $showResource;
    protected $selectResource;
    protected $policy = false;
    protected $eagerLoadRelationIndex = [];
    protected $eagerLoadRelationShow = [];

    public function __construct()
    {
        if (is_null($this->namespace)) $this->namespace = get_class($this->repository);
        $repository = app($this->namespace);

        $this->fillable = (clone $repository)->getFillable();
        if (is_null($this->indexResource)) $this->indexResource = (clone $repository)->getResource();
        if (is_null($this->showResource)) $this->showResource = (clone $repository)->getShowResource();
        if (is_null($this->selectResource)) $this->selectResource = (clone $repository)->getSelectResource();
    }

    public function index(Request $request) {
        $repository = $this->repository
            ->with($this->eagerLoadRelationIndex)
            ->criteria($request)
            ->filter($request);

        if ($request->has('search')) $repository = $repository->search($request->get('search'), null, true);

        $data = $request->has('per_page')
            ? $repository->paginate($request->per_page)
            : $repository->get();

        if ($this->indexResource && is_subclass_of($this->indexResource, JsonResource::class)) {
            return $this->indexResource::collection($data);
        }

        return DefaultResource::collection($data);
    }

    public function select(Request $request, $id = null) {
        $repository = $this->repository->criteria($request)
            ->filter($request);

        if ($id || $request->has('id')) {
            $data = $repository->findOrFail($id ?? $request->get('id'));

            if ($this->selectResource && is_subclass_of($this->selectResource, JsonResource::class)) return new $this->selectResource($data);

            return new SelectResource($data);
        }

        if ($request->has('search')) $repository = $repository->search($request->get('search'), null, true);

        $data = $request->has('per_page')
            ? $repository->paginate($request->per_page)
            : $repository->get();

        if ($this->selectResource && is_subclass_of($this->selectResource, JsonResource::class)) {
            return $this->selectResource::collection($data);
        }

        return SelectResource::collection($data);
    }

    public function show(Request $request, $id) {
        $data = $this->repository
            ->with($this->eagerLoadRelationShow)
            ->filter($request)
            ->findOrFail($id);

        if ($this->policy) $this->authorize('view', $data);

        if ($this->showResource && is_subclass_of($this->showResource, JsonResource::class)) {
            return new $this->showResource($data);
        }

        return new DefaultResource($data);
    }

    public function destroy(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $data = $this->repository->filter($request)->findOrFail($id);

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
