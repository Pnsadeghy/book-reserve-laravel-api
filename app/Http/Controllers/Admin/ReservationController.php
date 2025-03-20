<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommonIndexRequest;
use App\Http\Resources\Admin\Reservation\AdminReservationResource;
use App\Interfaces\IReservationRepository;
use App\Models\Reservation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @group Admin
 *
 * @subgroup Reservation
 *
 * @authenticated
 *
 * API endpoints for managing user reservation
 */
class ReservationController extends Controller
{
    public function __construct(protected IReservationRepository $repository) {}

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
        return AdminReservationResource::collection(
            $this->repository
                ->includeBookCopy()
                ->includeBranch()
                ->includeUser()
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
        return response()->json(new AdminReservationResource($reservation));
    }

    /**
     * Complete
     *
     * Only when reservation status = active
     *
     * @response 200
     */
    public function complete(Reservation $reservation) {}
}
