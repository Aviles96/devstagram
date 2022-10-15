<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    use HasFactory;
    //Para llenar los followers para que laravel tenga esa proteccion para que sepa que datos esperar
    protected $fillable = [
        'user_id',
        'follower_id'
    ];
}
