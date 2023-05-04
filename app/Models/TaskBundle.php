<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskBundle extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "category",
        "description"
    ];

    public function tasks(): HasMany {
        return $this->hasMany(Task::class);
    }

}
