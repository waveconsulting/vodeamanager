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
    protected $policies;

    protected $indexResource;
    protected $showResource;
    protected $selectResource;

    protected $eagerLoadRelationIndex = [];
    protected $eagerLoadRelationShow = [];
    protected $eagerLoadRelationSelect = [];

    protected $indexSearchRelevance;
    protected $selectSearchRelevance;

    protected $decodeIndexSearch;
    protected $decodeSelectSearch;

    public function __construct()
    {
        if (is_null($this->namespace)) {
            $this->namespace = get_class($this->repository);
        }

        $repository = app($this->namespace);
        $this->fillable = $repository->getFillable();

        if (is_null($this->indexResource)) {
            $this->indexResource = $repository->getResource();
        }

        if (is_null($this->showResource)) {
            $this->showResource = $repository->getShowResource();
        }

        if (is_null($this->selectResource)) {
            $this->selectResource = $repository->getSelectResource();
        }

        $this->indexSearchRelevance = config('vodeamanager.search_relevance_default', [null, true]);
        $this->selectSearchRelevance = config('vodeamanager.search_relevance_default', [null, true]);

        $this->decodeIndexSearch = config('vodeamanager.decode_search', false);
        $this->decodeSelectSearch = config('vodeamanager.decode_search', false);
    }

    public function index(Request $request)
    {
        if ($request->has('search') && $this->repository->isWithSearchable()) {
            $search = $request->get('search');
            if (config('vodeamanager.decode_search', false)) {
                $search = urldecode($search);
            }

            $repository = $this->repository->search($search, ...$this->indexSearchRelevance);
        } else {
            $repository = $this->repository->query();
        }

        if ($request->has('with')) {
            $this->eagerLoadRelationIndex = array_merge($this->eagerLoadRelationIndex, arr_strict($request->get('with')));
        }

        $repository = $repository->with(array_unique($this->eagerLoadRelationIndex))
            ->criteria($request)
            ->filter($request)
            ->subQueryIndex($request);

        $data = $request->has('per_page')
            ? $repository->paginate($request->get('per_page'))
            : $repository->get();

        return ResourceService::jsonCollection($this->indexResource,$data);
    }

    public function select(Request $request, $id = null)
    {
        if ($request->has('with')) {
            $this->eagerLoadRelationSelect = array_merge($this->eagerLoadRelationSelect, arr_strict($request->get('with')));
        }

        $repository = (clone $this->repository)
            ->with(array_unique($this->eagerLoadRelationSelect))
            ->filter($request)
            ->subQuerySelect($request);

        if ($id || $request->has('id')) {
            $data = $repository->findOrFail($id ?? $request->get('id'));

            return ResourceService::jsonResource($this->selectResource,$data);
        }

        $repository = $repository->criteria($request);

        if ($request->has('search') && $this->repository->isWithSearchable()) {
            $search = $request->get('search');
            if ($this->decodeSelectSearch) {
                $search = urldecode($search);
            }

            $repository = $repository->search($request->get('search'), ...$this->selectSearchRelevance);
        }

        $data = $request->has('per_page')
            ? $repository->paginate($request->get('per_page'))
            : $repository->get();

        return ResourceService::jsonCollection($this->selectResource,$data);
    }

    public function show(Request $request, $id)
    {
        if ($request->has('with')) {
            $this->eagerLoadRelationShow = array_merge($this->eagerLoadRelationShow, arr_strict($request->get('with')));
        }

        $data = $this->repository->with(array_unique($this->eagerLoadRelationShow))
            ->filter($request)
            ->subQueryShow($request)
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
