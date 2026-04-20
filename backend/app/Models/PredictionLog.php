<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PredictionLog extends Model
{
    protected $fillable = [
        'symbol',
        'predicted_price',
        'confidence',
        'model_used',
    ];
}
