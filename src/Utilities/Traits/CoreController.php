<?php

namespace Vodeamanager\Core\Utilities\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Vodeamanager\Core\Http\Resources\SelectResource;

trait CoreController
{
    protected $repository;
    protected $fillable;
    protected $resource;
    protected $selectResource;
    protected $policy = false;
    protected $view;
    protected $page;

    public function index(Request $request) {
        $repository = $request->has('search')
            ? $this->repository->search($request->get('search'), null, true)
            : $this->repository;

        $data = $request->has('per_page')
            ? $repository->all()
            : $repository->paginate($request->per_page);

        return view("$this->view.index", [
            'data' => $data,
            'page' => $this->page,
        ]);
    }

    public function select(Request $request, $id = null) {
        if ($id || $request->id) {
            $data = $this->repository->findOrFail($id ?? $request->id);

            return new SelectResource($data);
        }

        $repository = $request->has('search')
            ? $this->repository->search($request->get('search'), null, true)
            : $this->repository;

        $data = $request->has('per_page')
            ? $repository->all()
            : $repository->paginate($request->per_page);

        if (is_subclass_of($this->selectResource, JsonResource::class)) {
            return $this->selectResource::collection($data);
        }

        return SelectResource::collection($data);
    }

    public function create(Request $request)
    {
        return view("$this->view.detail");
    }

    public function show($id) {
        $data = $this->repository->findOrFail($id);

        if ($this->policy) {
            $this->authorize('view', $data);
        }

        return view("$this->view.detail",[
            'data' => $data,
            'page' => $this->page,
        ]);
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $data = $this->repository->findOrFail($id);

            if ($this->policy) {
                $this->authorize('delete', $data);
            }

            $this->repository->destroy($id);

            DB::commit();

            return redirect()->back()->with('message', 'Data deleted.');
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error'   => true,
                'message' => $e->getMessage()
            ]);
        }
    }
}
