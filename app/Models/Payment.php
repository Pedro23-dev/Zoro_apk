<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [];

    public function employer(){
        return $this->belongsTo(Employer::class);
    }
    use HasFactory;
}
