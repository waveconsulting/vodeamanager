<?php

namespace Vodeamanager\Core\Utilities\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Vodeamanager\Core\Http\Resources\DefaultResource;
use Vodeamanager\Core\Http\Resources\SelectResource;
use Vodeamanager\Core\Utilities\Facades\ExceptionService;

trait CoreController
{
    protected $repository;
    protected $namespace;
    protected $fillable;
    protected $resource;
    protected $selectResource;
    protected $view;
    protected $page;
    protected $policy = false;
    protected $indexData = false;

    public function __construct()
    {
        if (!$this->namespace) $this->namespace = get_class($this->repository);
        $this->fillable = app($this->namespace)->getFillable();
    }

    public function index(Request $request) {
        $returnData = [
            'page' => $this->page,
        ];

        if ($this->indexData) {
            $repository = $this->repository->criteria($request)
                ->filter($request);

            if ($request->has('search')) $repository = $repository->search($request->get('search'), null, true);

            $data = $request->has('per_page')
                ? $repository->paginate($request->per_page)
                : $repository->get();

            $returnData['data'] = is_subclass_of($this->resource, JsonResource::class)
                ? $this->resource::collection($data)
                : DefaultResource::collection($data);
        }

        return view("$this->view.index", $returnData);
    }

    public function select(Request $request, $id = null) {
        $repository = $this->repository->criteria($request)
            ->filter($request);

        if ($id || $request->has('id')) {
            $data = $repository->findOrFail($id ?? $request->get('id'));

            return new SelectResource($data);
        }

        if ($request->has('search')) $repository = $repository->search($request->get('search'), null, true);

        $data = $request->has('per_page')
            ? $repository->paginate($request->per_page)
            : $repository->get();

        if (is_subclass_of($this->selectResource, JsonResource::class)) return $this->selectResource::collection($data);

        return SelectResource::collection($data);
    }

    public function create() {
        return view("$this->view.detail");
    }

    public function show(Request $request, $id) {
        $data = $this->repository->filter($request)->findOrFail($id);

        if ($this->policy) $this->authorize('view', $data);

        return view("$this->view.show", [
            'data' => $data,
            'page' => $this->page,
        ]);
    }

    public function json(Request $request, $id) {
        $data = $this->repository->filter($request)->findOrFail($id);

        if ($this->policy) $this->authorize('view', $data);

        return is_subclass_of($this->resource, JsonResource::class)
            ? new $this->resource($data)
            : new DefaultResource($data);
    }

    public function edit(Request $request, $id) {
        $data = $this->repository->filter($request)->findOrFail($id);

        if ($this->policy) $this->authorize('update', $data);

        return view("$this->view.detail",[
            'data' => $data,
            'page' => $this->page,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $data = $this->repository->filter($request)->findOrFail($id);

            if ($this->policy) $this->authorize('delete', $data);

            $this->repository->destroy($id);

            DB::commit();

            return redirect()->back()->with('message', 'Data deleted.');
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
