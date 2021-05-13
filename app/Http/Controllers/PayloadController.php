<?php

namespace App\Http\Controllers;

use App\Domain\Payload\Actions\LoadPayloadAction;
use App\Domain\Payload\DTO\PayloadData;
use App\Domain\Payload\Exceptions\StorePayloadException;
use App\Location;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as ResponseCodes;
use Illuminate\Support\Facades\Response;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class PayloadController
 * @package App\Http\Controllers
 */
class PayloadController extends Controller
{
    /**
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function index(Request $request): LengthAwarePaginator
    {
        // Return list paginate of localizations
        return QueryBuilder::for(Location::class)
            ->allowedFilters([
                AllowedFilter::scope('created_at_between'),
            ])
            ->allowedSorts(['lat', 'lng', 'from', 'origin', 'address', 'created_at'])
            ->paginate(50);
    }

    /**
     * @param Request $request
     * @param LoadPayloadAction $loadPayloadAction
     * @return JsonResponse
     */
    public function store(Request $request, LoadPayloadAction $loadPayloadAction): JsonResponse
    {
        try {
            // Proces request for save payload
            $created = $loadPayloadAction->__invoke(PayloadData::fromRequest($request));
        }catch (StorePayloadException $storePayloadException){
            // If fail response message of exception
            return Response::json(['message' => $storePayloadException->getMessage()], ResponseCodes::HTTP_UNPROCESSABLE_ENTITY);
        }

        // If create response
        return $created ? Response::json(['message' => trans('payload.store_success')], ResponseCodes::HTTP_CREATED)
        : Response::json(['message' => trans('payload.store_fail')], ResponseCodes::HTTP_UNPROCESSABLE_ENTITY);
    }
}
