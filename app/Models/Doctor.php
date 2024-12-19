<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'name',
        'specialization_id',
        'contact',
        'email',
    ];
    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }
}
