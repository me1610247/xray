<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = [
        'user_id', 'model_type', 'label', 'confidence', 'recommendation', 
        'description', 'description_confidence', 'raw_response','image',
    ];
}
