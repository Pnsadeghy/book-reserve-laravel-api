<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommonIndexRequest;
use App\Http\Resources\User\Reservation\UserReservationResource;
use App\Interfaces\IReservationRepository;
use App\Models\Reservation;
use App\Models\Scopes\AuthUserScope;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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
    public function __construct(protected IReservationRepository $repository)
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
    public function show(Reservation $reservation) {}

    /**
     * Store new user reservation
     *
     * @bodyParam book_copy_id required uuid
     * @bodyParam days required int
     */
    public function store() {}

    /**
     * Cancel pending reservation
     * Only when reservation status = pending
     *
     * @response 200
     */
    public function cancel(Reservation $reservation) {}
}
