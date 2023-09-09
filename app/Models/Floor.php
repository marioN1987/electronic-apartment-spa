<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Floor extends Model
{
    use HasFactory;

    protected $fillable = ['floor_no','apartments_per_floor'];

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class, 'house_id', 'id');
    }
}
