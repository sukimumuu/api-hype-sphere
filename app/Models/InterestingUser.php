<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InterestingUser extends Model
{
    protected $guarded = ['id'];

    public function users(): BelongsTo {

        return $this->belongsTo(User::class);

    }
}
