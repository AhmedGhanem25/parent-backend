<?php

namespace App\Http\Resources\AdminPortal;

use App\Enums\DataProviderXStatuses;
use App\Enums\DataProviderYStatuses;
use Illuminate\Http\Resources\Json\JsonResource;

class ListParentsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->parentIdentification ?? $this->id,
            "balance" => $this->parentAmount ??  $this->balance,
            "currency" => $this->Currency ?? $this->currency,
            "email" => $this->parentEmail ?? $this->email,
            "status" => isset($this->statusCode) ? DataProviderXStatuses::getStatusEquivalentString($this->statusCode): DataProviderYStatuses::getStatusEquivalentString($this->status),
            "created_at" => $this->registerationDate ?? $this->created_at
        ];
    }
}
