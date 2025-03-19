<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Book\AdminBookStoreRequest;
use App\Http\Requests\Admin\Book\AdminBookUpdateRequest;
use App\Http\Requests\CommonIndexRequest;
use App\Http\Resources\Admin\Book\AdminBookListItemResource;
use App\Http\Resources\Admin\Book\AdminBookResource;
use App\Interfaces\IBookRepository;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

/**
 * @group Admin
 *
 * @subgroup Book
 *
 * @authenticated
 *
 * API endpoints for managing books
 */
class BooksController extends Controller
{
    public function __construct(protected IBookRepository $repository) {}

    /**
     * All books
     *
     * @queryParam q string
     * @queryParam page integer
     * @queryParam per_page integer
     *
     * @responseFile 200 resources/responses/Admin/Book/index.json
     */
    public function index(CommonIndexRequest $request): AnonymousResourceCollection
    {
        return AdminBookListItemResource::collection(
            $this->repository
                ->search($request->string('q'))
                ->paginate([
                    'id', 'title', 'description', 'is_visible', 'created_at',
                ])
        );
    }

    /**
     * Store
     *
     * @bodyParam title required
     * @bodyParam description
     * @bodyParam visible required boolean
     *
     * @responseFile 201 resources/responses/Admin/Book/store.json
     */
    public function store(AdminBookStoreRequest $request): JsonResponse
    {
        $model = $this->repository->store($request->validated());

        return response()->json(new AdminBookResource($model), 201);
    }

    /**
     * Show
     *
     * @responseFile 200 resources/responses/Admin/Book/show.json
     */
    public function show(Book $book): JsonResponse
    {
        return response()->json(new AdminBookResource($book));
    }

    /**
     * Update
     *
     * @bodyParam title
     * @bodyParam description
     * @bodyParam visible boolean
     *
     * @response 200
     */
    public function update(AdminBookUpdateRequest $request, Book $book): JsonResponse
    {
        $this->repository->update($book, $request->validated());

        return response()->json();
    }

    /**
     * Destroy
     *
     * @response 204
     */
    public function destroy(Book $book): Response
    {
        // TODO we have a better logic for this action when book have reservation, for now we just use soft delete
        $this->repository->delete($book);

        return response()->noContent();
    }
}
