<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamBundle extends Model
{
    use HasFactory;

    protected $fillable = [
        "assignment_id",
        "task_bundle_id",
        "points",
        "title"
    ];

    public function AssigmentBundle(): BelongsTo {
        return $this->belongsTo(Assignment::class);
    }
}