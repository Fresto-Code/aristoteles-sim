<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Magazine extends Model
{
    use SoftDeletes;
    use HasFactory;
    
    protected $guarded = ['id', 'timestamps'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $dates = [ 'deleted_at' ];
}
