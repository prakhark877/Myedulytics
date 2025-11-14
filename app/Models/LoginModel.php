<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginModel extends Model
{
    use HasFactory;

       protected $table = 'users';
    
    protected $fillable = [
        'student_email',
        'student_password',
    ];

    public $timestamps = false;
}
