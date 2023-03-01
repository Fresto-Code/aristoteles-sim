<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enterprise extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $guarded = ['id', 'timestamps'];
    protected $dates = ['deleted_at'];

    protected $casts = [
        'id' => 'string',
    ];
}
