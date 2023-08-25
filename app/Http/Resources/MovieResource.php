<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        return [
            'airport_id' => $request->airport_id,
            'code_iata' => $request->code_iata,
            'code_icao' => $request->code_icao,
            'cargo_offload' => $request->cargo_offload,
            'cargo_load' => $request->cargo_load,
            'landing' => $request->landing,
            'takeoff' => $request->takeoff,
        ];
    }
}
