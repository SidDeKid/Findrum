<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drummer extends Model
{
    use HasFactory;

    protected $guarded = ["id"];
    protected $fillable = ["first_name", "last_name" ];

    public function bands()
    {
        return $this->belongsToMany(Band::class);
    }
    public function components()
    {
        // return $this->belongsToMany(Component::class);
        return $this->belongsToMany(Component::class);
    }
}
