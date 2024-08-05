<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserTask extends Model
{
    use HasFactory;


    public function masterTask(): BelongsTo
    {
        return $this->belongsTo(MasterTask::class);
    }
}
