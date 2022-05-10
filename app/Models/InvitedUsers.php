<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitedUsers extends Model
{
    use HasFactory;
    protected $fillable = [
        'invitation_created_by','invited_email'
    ];
}
