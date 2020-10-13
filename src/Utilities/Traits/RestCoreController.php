<?php

namespace Vodeamanager\Core\Utilities\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Vodeamanager\Core\Utilities\Facades\ExceptionService;
use Vodeamanager\Core\Utilities\Facades\ResourceService;

trait RestCoreController
{
    protected $repository;
    protected $namespace;
    protected $fillable;
    protected $indexResource;
    protected $showResource;
    protected $selectResource;
    protected $policies;
    protected $eagerLoadRelationIndex = [];
    protected $eagerLoadRelationShow = [];
    protected $eagerLoadRelationSelect = [];

    public function __construct()
    {
        if (is_null($this->namespace)) {
            $this->namespace = get_class($this->repository);
        }

        $repository = app($this->namespace);
        $this->fillable = (clone $repository)->getFillable();

        if (is_null($this->indexResource)) {
            $this->indexResource = (clone $repository)->getResource();
        }

        if (is_null($this->showResource)) {
            $this->showResource = (clone $repository)->getShowResource();
        }

        if (is_null($this->selectResource)) {
            $this->selectResource = (clone $repository)->getSelectResource();
        }
    }

    public function index(Request $request)
    {
        if ($request->has('search') && !empty($this->repository->getSearchable())) {
            $repository = $this->repository->search($request->get('search'), null, true);
        } else {
            $repository = $this->repository->query();
        }

        if ($request->has('with')) {
            $with = $request->get('with');
            $this->eagerLoadRelationIndex = array_merge(
                $this->eagerLoadRelationIndex,
                is_array($with) ? $with : [$with]
            );
        }

        $repository = $repository->with(array_unique($this->eagerLoadRelationIndex))
            ->criteria($request)
            ->filter($request)
            ->subQuery($request);

        $data = $request->has('per_page')
            ? $repository->paginate($request->get('per_page'))
            : $repository->get();

        return ResourceService::jsonCollection($this->indexResource,$data);
    }

    public function select(Request $request, $id = null)
    {
        if ($request->has('with')) {
            $with = $request->get('with');
            $this->eagerLoadRelationSelect = array_merge(
                $this->eagerLoadRelationSelect,
                is_array($with) ? $with : [$with]
            );
        }

        $repository = (clone $this->repository)
            ->with(array_unique($this->eagerLoadRelationSelect))
            ->filter($request)
            ->subQuery($request);

        if ($id || $request->has('id')) {
            $data = $repository->findOrFail($id ?? $request->get('id'));

            return ResourceService::jsonResource($this->selectResource,$data);
        }

        $repository = $repository->criteria($request);

        if ($request->has('search') && !empty($this->repository->getSearchable())) {
            $repository = $repository->search($request->get('search'), null, true);
        }

        $data = $request->has('per_page')
            ? $repository->paginate($request->get('per_page'))
            : $repository->get();

        return ResourceService::jsonCollection($this->selectResource,$data);
    }

    public function show(Request $request, $id)
    {
        if ($request->has('with')) {
            $with = $request->get('with');
            $this->eagerLoadRelationShow = array_merge(
                $this->eagerLoadRelationShow,
                is_array($with) ? $with : [$with]
            );
        }

        $data = $this->repository->with(array_unique($this->eagerLoadRelationShow))
            ->filter($request)
            ->subQuery($request)
            ->findOrFail($id);

        $this->gate($data, __FUNCTION__);

        return ResourceService::jsonResource($this->showResource,$data);
    }

    public function destroy(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $data = $this->repository->filter($request)->findOrFail($id);

            $this->gate($data, __FUNCTION__);

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

    private function gate(Model $data, $policyName) {
        if (!empty($this->policies)) {
            if ((is_bool($this->policies) && $this->policies) ||
                (is_array($this->policies) && in_array($policyName, $this->policies)) ||
                (is_string($this->policies) && $this->policies == $policyName)) {
                $this->authorize($policyName, $data);
            }
        }
    }
}
