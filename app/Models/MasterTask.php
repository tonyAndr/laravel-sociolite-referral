<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MasterTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'requested',
        'price',
        'ref_url',
        'proof_type',
        'status',
        'title',
        'description',
        'fullfilled',
        'user_reward'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function userTasks(): HasMany
    {
        return $this->hasMany(UserTask::class);
    }
}
