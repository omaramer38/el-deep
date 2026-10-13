<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'company',
        'subject_ref',
        'message',
        'attachment_path',
        'status',
        'ip_hash',
        'user_agent',
        'notes',
    ];
}
