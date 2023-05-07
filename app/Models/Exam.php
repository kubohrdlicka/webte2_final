<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        "studen_solution",
        "earned_points",
        "task_id",
        "exam_bundle_id",
        "user_id"
    ];

    public function task(): BelongsTo {
        return $this->belongsTo(Task::class);
    }

    public function examBundle(): BelongsTo {
        return $this->belongsTo(ExamBundle::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
    
}