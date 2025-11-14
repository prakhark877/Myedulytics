<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class RegistrationModel extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;

    protected $table = 'users';
    public $timestamps = false;

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
        'preset',
        'curriculum',
        'grade',
        'languages',
        'academic',
        'activities',
        'studyhours',
        'learningpreferences',
        'consent'
    ];

    protected $casts = [
        'learningpreferences' => 'array',
        'consent' => 'array',
    ];

    public function getEmailForVerification()
    {
        return $this->student_email;
    }
}
