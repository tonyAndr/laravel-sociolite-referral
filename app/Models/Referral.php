<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    /**
     * Scope a query to only include not from user referrals.
     *
     */
    public static function notFromSameUser($parent_id, $invited_id)
    {
        return intval($invited_id) !== intval($parent_id);
    }



    
}