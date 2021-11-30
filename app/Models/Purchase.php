<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Purchase extends Model
{
    protected $fillable = ['offer_vendor', 'offer_id', 'offer_title', 'offer_price', 'offer_quantity', 'offer_address', 'user_id'];
    use HasFactory;

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


}
