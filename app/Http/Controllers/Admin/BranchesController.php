<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Branch\AdminBranchStoreRequest;
use App\Http\Requests\Admin\Branch\AdminBranchUpdateRequest;
use App\Http\Requests\CommonIndexRequest;
use App\Http\Resources\Admin\Branch\AdminBranchListItemResource;
use App\Http\Resources\Admin\Branch\AdminBranchResource;
use App\Interfaces\IBranchRepository;
use App\Models\Branch;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

/**
 * @group Admin
 *
 * @subgroup Branch
 *
 * @authenticated
 *
 * API endpoints for managing branches
 */
class BranchesController extends Controller
{
    public function __construct(protected IBranchRepository $repository) {}

    /**
     * All books
     *
     * @queryParam q string
     * @queryParam page integer
     * @queryParam per_page integer
     *
     * @responseFile 200 resources/responses/Admin/Branch/index.json
     */
    public function index(CommonIndexRequest $request): AnonymousResourceCollection
    {
        return AdminBranchListItemResource::collection(
            $this->repository
                ->search($request->string('q'))
                ->paginate([
                    'id', 'title', 'address', 'is_visible', 'created_at',
                ])
        );
    }

    /**
     * Store
     *
     * @bodyParam title required
     * @bodyParam address
     * @bodyParam visible required boolean
     *
     * @responseFile 201 resources/responses/Admin/Branch/store.json
     */
    public function store(AdminBranchStoreRequest $request): JsonResponse
    {
        $model = $this->repository->store($request->validated());

        return response()->json(new AdminBranchResource($model), 201);
    }

    /**
     * Show
     *
     * @responseFile 200 resources/responses/Admin/Branch/show.json
     */
    public function show(Branch $branch): JsonResponse
    {
        return response()->json(new AdminBranchResource($branch));
    }

    /**
     * Update
     *
     * @bodyParam title
     * @bodyParam address
     * @bodyParam visible boolean
     *
     * @response 200
     */
    public function update(AdminBranchUpdateRequest $request, Branch $branch): JsonResponse
    {
        $this->repository->update($branch, $request->validated());

        return response()->json();
    }

    /**
     * Destroy
     *
     * @response 204
     */
    public function destroy(Branch $branch): Response
    {
        // TODO we have a better logic for this action when branch have copies, for now we just use soft delete
        $this->repository->delete($branch);

        return response()->noContent();
    }
}
