<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoGuideLine extends Model
{
    use HasFactory;

    protected $table = 'video_guide_lines';

    protected $fillable = [
        'title',
        'description',
        'file_path',
        'file_type',
        'uploaded_by',
        'upload_date',
        'visibility'
    ];

    protected $casts = [
        'upload_date' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
