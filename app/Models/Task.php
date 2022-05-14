<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Task extends Model
{
    use HasFactory,HasApiTokens;

     protected $fillable = [
        'name',
        'description',
        'board_id',
    ];

  
}
