<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizzesAnswer extends Model
{
    use HasFactory;
    protected $table = 'quizzes_answer'; // Table name explicitly define karein
    protected $primaryKey = 'id'; // Primary key set karein
    public $timestamps = true; // Agar timestamps (created_at, updated_at) use ho rahe hain
    protected $fillable = [
        'options_id',
        'quiz_id',
        'options_result',
        'options_description'
    ];
    public $incrementing = true;
   
}
