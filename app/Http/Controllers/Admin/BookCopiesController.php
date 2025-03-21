<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BookCopy\AdminBookCopyStoreRequest;
use App\Http\Requests\Admin\BookCopy\AdminBookCopyUpdateRequest;
use App\Http\Requests\CommonIndexRequest;
use App\Http\Resources\Admin\BookCopy\AdminBookCopyResource;
use App\Interfaces\IBookCopyRepository;
use App\Models\Book;
use App\Models\BookCopy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

/**
 * @group Admin
 *
 * @subgroup Book copies
 *
 * @authenticated
 *
 * API endpoints for managing book copies
 */
class BookCopiesController extends Controller
{
    public function __construct(protected IBookCopyRepository $repository) {}

    /**
     * All book copies
     *
     * @responseFile 200 resources/responses/Admin/BookCopy/index.json
     */
    public function index(CommonIndexRequest $request, Book $book): JsonResponse
    {
        return response()->json(AdminBookCopyResource::collection($book->copies()->get()));
    }

    /**
     * Store new book copy
     *
     * @bodyParam title required string
     * @bodyParam status required string values: available,under_repair,lost
     * @bodyParam condition required string values: good,worn,damaged
     * @bodyParam branch_id required uuid
     * @bodyParam visible required boolean
     * @bodyParam special required boolean
     *
     * @responseFile 201 resources/responses/Admin/BookCopy/store.json
     */
    public function store(AdminBookCopyStoreRequest $request, Book $book): JsonResponse
    {
        $data = $request->validated();
        $data['book_id'] = $book->id;

        $model = $this->repository->store($data);

        return response()->json(new AdminBookCopyResource($model), 201);
    }

    /**
     * Show book copy
     *
     * @responseFile 200 resources/responses/Admin/BookCopy/show.json
     */
    public function show(BookCopy $bookCopy): JsonResponse
    {
        return response()->json(new AdminBookCopyResource($bookCopy), 201);
    }

    /**
     * Update book copy
     *
     * @bodyParam title string
     * @bodyParam condition string values: good,worn,damaged - Only when the copy is not reserved
     * @bodyParam status string values: available,under_repair - Only when the copy is not reserved
     * @bodyParam branch_id uuid - Only when the copy is not reserved
     * @bodyParam visible boolean
     * @bodyParam special boolean
     *
     * @response 200
     */
    public function update(AdminBookCopyUpdateRequest $request, BookCopy $bookCopy): JsonResponse
    {
        $this->repository->update($bookCopy, $request->validated());

        return response()->json([]);
    }

    /**
     * Destroy book copy
     *
     * @response 204
     */
    public function destroy(BookCopy $bookCopy): Response
    {
        Gate::authorize('delete', $bookCopy);

        $this->repository->delete($bookCopy);

        return response()->noContent();
    }
}
