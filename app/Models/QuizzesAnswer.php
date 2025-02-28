<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizzesAnswer extends Model
{
    use HasFactory;
    protected $table = 'quizzes_answer'; // Table name explicitly define karein
    protected $primaryKey = 'id'; // Primary key set karein
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'result_options',
        'quiz_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'result_options' => 'array',  // Automatically cast options as an array
    ];

    /**
     * Define a relationship with the Quiz model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
