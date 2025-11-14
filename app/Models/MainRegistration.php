<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainRegistration extends Model
{
    use HasFactory;

     // Primary key (optional; only include if it's not 'id')   

    protected $table = 'registration';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'dob',
        'password',
        'confirm_password',
    ];

    public $timestamps = false;
}
