<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable=['offer_id'];

    public function offer(): BelongsTo
    {
        return $this->belongsTo(Offer::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class,UserReservation::class);
    }
}
