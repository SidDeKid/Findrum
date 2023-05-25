<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public function drummers()
    {
        // return $this->belongsToMany(Drummer::class);
        return $this->hasOne(Drummer::class);
    }
    public function brand()
    {
        return $this->hasOne(Brand::class);
    }
}
