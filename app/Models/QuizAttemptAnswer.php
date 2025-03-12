<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAttemptAnswer extends Model
{
    use HasFactory;

    protected $table = 'quiz_attempt_answer';

    protected $fillable = [
        'quiz_id',
        'total_attempt_question',
        'total_attempt_time',
        'total_correct_answer',
        'user_id',
        'answer',
        'options_id',
        'quizzes_answer_id'
    ];

    // Define relationships if applicable
    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
