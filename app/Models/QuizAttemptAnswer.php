<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAttemptAnswer extends Model
{
    use HasFactory;

    protected $table = 'quiz_attempt_answer'; // ✅ must match your database table name

    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }
}
