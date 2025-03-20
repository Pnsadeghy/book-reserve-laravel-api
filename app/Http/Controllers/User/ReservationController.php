<?php

namespace App\Http\Controllers\User;

use App\Enums\ReservationStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommonIndexRequest;
use App\Http\Requests\User\Reservation\UserReservationStoreRequest;
use App\Http\Resources\User\Reservation\UserReservationResource;
use App\Interfaces\IBookCopyRepository;
use App\Interfaces\IReservationRepository;
use App\Models\Reservation;
use App\Models\Scopes\AuthUserScope;
use App\Services\UserReservationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;

/**
 * @group User
 *
 * @subgroup Reservation
 *
 * @authenticated
 *
 * API endpoints for managing reservation
 */
class ReservationController extends Controller
{
    public function __construct(protected IReservationRepository $repository,
                                protected IBookCopyRepository $bookCopyRepository,
                                protected UserReservationService $userReservationService)
    {
        Reservation::addGlobalScope(AuthUserScope::class);
    }

    /**
     * All reservations
     *
     * @queryParam page integer
     * @queryParam per_page integer
     *
     * @responseFile 200 resources/responses/Admin/Reservation/index.json
     */
    public function index(CommonIndexRequest $request): AnonymousResourceCollection
    {
        return UserReservationResource::collection(
            $this->repository
                ->includeBookCopy()
                ->includeBranch()
                ->paginate()
        );
    }

    /**
     * Show
     *
     * @responseFile 200 resources/responses/Admin/Reservation/show.json
     */
    public function show(Reservation $reservation): JsonResponse
    {
        $reservation->load(['bookCopy', 'bookCopy.book', 'branch']);
        return response()->json(new UserReservationResource($reservation));
    }

    /**
     * Store new user reservation
     *
     * @bodyParam book_copy_id required uuid
     * @bodyParam days required int min:1
     */
    public function store(UserReservationStoreRequest $request): JsonResponse {
        $bookCopy = $this->bookCopyRepository->find($request->string("book_copy_id"));
        Gate::authorize('reserve', $bookCopy);

        $reservation = $this->userReservationService->add(auth()->user(), $bookCopy, $request->integer('days'));

        $reservation->load(['bookCopy', 'bookCopy.book', 'branch']);
        return response()->json(new UserReservationResource($reservation));
    }

    /**
     * Cancel
     *
     * Only when reservation status = pending
     *
     * @response 200
     */
    public function cancel(Reservation $reservation): JsonResponse
    {
        Gate::authorize('cancel', $reservation);

        $this->repository->update($reservation, [
            'status' => ReservationStatusEnum::Canceled,
        ]);

        return response()->json([]);
    }
}
