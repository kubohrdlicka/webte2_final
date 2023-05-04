<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        "instructions",
        "solution"
    ];

    public function taskBundle(): BelongsTo {
        return $this->belongsTo(TaskBundle::class);
    }

}
