<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommonIndexRequest;
use App\Http\Resources\Admin\Branch\AdminBranchListItemResource;
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
     */
    public function store(): JsonResponse
    {
        // TODO Complete: Branch store action + api doc
        return response()->json([], 201);
    }

    /**
     * Show
     */
    public function show(Branch $branch): JsonResponse
    {
        // TODO Complete: Branch show action + api doc
        return response()->json([]);
    }

    /**
     * Update
     */
    public function update(Branch $branch): JsonResponse
    {
        // TODO Complete: Branch update action + api doc
        return response()->json([]);
    }

    /**
     * Destroy
     */
    public function destroy(Branch $branch): Response
    {
        // TODO Complete: Branch destroy action + api doc
        return response()->noContent();
    }
}
