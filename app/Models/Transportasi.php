<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transportasi extends Model
{
    use HasFactory;

    use HasFactory;

    protected $guarded = [];

    public function homestay(){
        return $this->belongsTo(Homestay::class);
    }
}
