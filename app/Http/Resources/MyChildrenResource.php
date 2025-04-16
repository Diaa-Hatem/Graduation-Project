<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MyChildrenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'age' => \Carbon\Carbon::parse($this->birth_date)->age,
            "image" => $this->image,
            "gender"=>$this->gender,
            "report" => $this->report,
            "total_questions_score" => $this->questions_score,
            "ml_result" => $this->ml_result,
            "final_diagnosis" => $this->final_diagnosis,
        ];
    }
}
