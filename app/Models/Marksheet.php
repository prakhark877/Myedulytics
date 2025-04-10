<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marksheet extends Model
{
    use HasFactory;

    // Explicitly define the table name if needed
    protected $table = 'marksheets';

    protected $fillable = [
        'description',
        'image',
        'image_description',
        'textract_raw',
        'user_id',
        'exam_type',
        'issued_at',
    ];

    protected $casts = [
        'textract_raw' => 'array',
        'issued_at' => 'date',
    ];

    // Relationship: Marksheet belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
