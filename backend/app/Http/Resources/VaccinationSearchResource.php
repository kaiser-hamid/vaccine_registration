<?php

namespace App\Http\Resources;

use App\Enum\RegistrationStatusEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class VaccinationSearchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => "{$this->first_name} {$this->last_name}",
            'email' => $this->email,
            'status' => $this->getStatus(),
            'date' => $this->vaccination_date ? Carbon::make($this->vaccination_date)->format('j F,  Y') : "Not available"
        ];
    }


    private function getStatus()
    {
        /** If the date is over, it will be marked as vaccinated */
        if($this->vaccination_date){
            if(Carbon::make($this->vaccination_date)->lt(Carbon::now())){
                return Str::headline(RegistrationStatusEnum::VACCINATED->value);
            }
        }
        return Str::headline($this->status->value);
    }
}
