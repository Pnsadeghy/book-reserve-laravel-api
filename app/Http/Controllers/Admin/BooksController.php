<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Book\AdminBookStoreRequest;
use App\Http\Requests\Admin\Book\AdminBookUpdateRequest;
use App\Http\Requests\CommonIndexRequest;
use App\Http\Resources\Admin\Book\AdminBookListItemResource;
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
 * API endpoints for managing books
 */
class BooksController extends Controller {
    public function __construct(protected IBookRepository $repository)
    {

    }

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
                    "id", "title", "description", "is_visible", "created_at"
                ])
        );
    }

    /**
     * Store
     */
    public function store(AdminBookStoreRequest $request): JsonResponse
    {
        #TODO Complete: Book store action + api doc
        return response()->json([], 201);
    }

    /**
     * Show
     */
    public function show(Book $book): JsonResponse
    {
        #TODO Complete: Book show action + api doc
        return response()->json([]);
    }

    /**
     * Update
     */
    public function update(AdminBookUpdateRequest $request, Book $book): JsonResponse
    {
        #TODO Complete: Book update action + api doc
        return response()->json([]);
    }

    /**
     * Show a book
     */
    public function destroy(Book $book): Response
    {
        #TODO Complete: Book destroy action + api doc
        return response()->noContent();
    }
}
