<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommonIndexRequest;
use App\Http\Resources\User\Book\UserBookListItemResource;
use App\Interfaces\IBookRepository;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @group User
 *
 * @subgroup Book
 *
 * API endpoints for get books information
 */
class BooksController extends Controller
{
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
     * @responseFile 200 resources/responses/User/Book/index.json
     */
    public function index(CommonIndexRequest $request): AnonymousResourceCollection
    {
        return UserBookListItemResource::collection(
            $this->repository
                ->visible()
                ->search($request->string('q'))
                ->paginate([
                    "id", "title", "description", "is_visible", "created_at"
                ])
        );
    }

    /**
     * Get book information
     *
     * @responseFile 200 resources/responses/User/Book/show.json
     */
    public function show(Book $book): JsonResponse
    {
        #TODO Complete: User Book resource show api
        return response()->json($book);
    }
}
