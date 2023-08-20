<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $fillable = [
        'cvegeo_key',
        'cvegeo',
        'cve_agee',
        'nom_agee',
        'nom_abrev',
        'pob',
        'pob_fem',
        'pob_mas',
        'viv'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'cvegeo_key'
    ];

    // Create a backup field in order to be able to match from API.
    public static function boot(){
        parent::boot();

        static::creating(function ( $state ) {
            $state->cvegeo_key = $state->cvegeo;
        });
    }
}
