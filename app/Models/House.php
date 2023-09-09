<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class House extends Model
{
    use HasFactory;

    protected $fillable = ['state_id'];

    public function state(): HasOne
    {
        return $this->hasOne(State::class, 'id', 'state_id');
    }

    public function floors(): HasMany
    {
        return $this->hasMany(Floor::class);
    }
}
