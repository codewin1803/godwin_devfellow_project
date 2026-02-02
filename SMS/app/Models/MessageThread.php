<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageThread extends Model
{
    protected $fillable = ['subject', 'created_by'];

    public function messages()
    {
        return $this->hasMany(Message::class, 'thread_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
