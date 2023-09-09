<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    public const PLANNING = 1;
    public const IN_DESIGN = 2;
    public const UNDER_CONSTRUCTION = 3;
    public const READY = 4;
}
