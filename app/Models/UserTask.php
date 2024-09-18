<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'master_task_id',
        'user_id',
        'expires_at',
        'product_id'
    ];

    public function masterTask(): BelongsTo
    {
        return $this->belongsTo(MasterTask::class);
    }
}
