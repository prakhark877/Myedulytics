<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgeGroups extends Model
{
    use HasFactory;

    protected $table = 'age_groups'; // Table name explicitly define karein
    protected $primaryKey = 'id'; // Primary key set karein

    public $timestamps = true; // Agar timestamps (created_at, updated_at) use ho rahe hain
    protected $fillable = [
        'name', 'min_age', 'max_age'
    ];

    // Agar primary key auto-increment nahi hai to
    public $incrementing = true;

    // Agar primary key ka type integer nahi hai to
    protected $keyType = 'int';
}
