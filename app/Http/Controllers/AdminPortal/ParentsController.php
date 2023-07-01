<?php

namespace App\Http\Controllers\AdminPortal;

use App\Enums\AResponses;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPortal\ListParentRequest;
use App\Http\Resources\AdminPortal\ListParentsResource;
use App\Services\ParentsService;
use Illuminate\Support\Facades\Log;

class ParentsController extends Controller
{
    private $parentsService;

    public function __construct(ParentsService $parentsService)
    {
        $this->parentsService = $parentsService;
    }

    public function getParentsAccounts(ListParentRequest $listParentRequest)
    {
        try {

            $parents = $this->parentsService->getParentsAccounts($listParentRequest->validated());
            $response = ListParentsResource::collection($parents);
            return response()->json([
                "status" => AResponses::SUCCESS,
                "data" => $response
            ], AResponses::SUCCESS);
        } catch (\Exception $e) {
            Log::info($e);
            return response()->json([
                "message" => "something went wrong"
            ], AResponses::INTERNAL_SERVER_ERROR);
        }
    }
}
