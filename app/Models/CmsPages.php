<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsPages extends Model
{
    use HasFactory;

    protected $table = 'cms_pages'; // Table name explicitly define karein
    protected $primaryKey = 'page_id'; // Primary key set karein

    public $timestamps = true; // Agar timestamps (created_at, updated_at) use ho rahe hain
    protected $fillable = [
        'page_slug', 'page_title', 'short_desc', 'content', 'page_type',
        'cat_id', 'subcat_id', 'pg_bgimg'
    ];

    // Agar primary key auto-increment nahi hai to
    public $incrementing = true;

    // Agar primary key ka type integer nahi hai to
    protected $keyType = 'int';
}
