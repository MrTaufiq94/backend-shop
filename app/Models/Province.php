<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'province_id', 'name'
    ];

}
