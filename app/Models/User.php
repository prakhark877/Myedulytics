<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $table = 'users'; // ✅ correct table name

    public $timestamps = false; // ✅ if your table doesn’t have created_at/updated_at

    protected $fillable = [
        'first_name',
        'last_name',
        'preferred_name',
        'dob',
        'student_email',
        'student_password',
        'parent_email',
        'parent_password',
        'country',
        'region',
        'city',
        'preset',
        'curriculum',
        'grade',
        'languages',
        'academic',
        'activities',
        'studyhours',
        'learningpreferences',
        'consent',
    ];
}
