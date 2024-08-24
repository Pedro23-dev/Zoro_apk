<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    use HasFactory;
    protected $guarded=[''];

    // Nom de la table si différent de celui attendu par défaut
    // protected $table = 'employers';

    public function deps()
    {
        return $this->belongsTo(Departement::class);
    }
    public function payments(){
        return $this->hasMany(Payment::class);
    }
}


