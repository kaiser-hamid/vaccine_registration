<?php

namespace App\Models;

use App\Enum\RegistrationStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VaccineRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'nid',
        'vaccine_center_id',
    ];

    protected $casts = [
        'status' => RegistrationStatusEnum::class
    ];

    public function vaccineCenter(): BelongsTo
    {
        return $this->belongsTo(VaccineCenter::class);
    }

}
