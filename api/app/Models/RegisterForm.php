<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterForm extends Model
{
    protected $fillable = [
        'event_id', 'user_id', 'first_name', 'last_name', 'hobbies'
    ];
}
