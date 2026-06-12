<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FomoData extends Model
{
    protected $table = 'fomo_data';

    protected $fillable = [
        'fake_name',
        'fake_city',
    ];
}
