<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assignment extends Model
{
    use HasFactory;

    public function createdBy(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        "title",
        "description",
        "start",
        "end",
        "created_by",
    ];

}
