<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Brand;

class Component extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public function drummers()
    {
        return $this->belongsToMany(Drummer::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
