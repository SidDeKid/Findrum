<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Band extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public function drummers()
    {
        return $this->belongsToMany(Drummer::class);
    }
}
