<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'thread_id',
        'sender_id',
        'receiver_id',
        'body',
        'attachment_path',
        'read_at',
        'is_deleted_by_sender',
        'is_deleted_by_receiver',
    ];

    protected $dates = ['read_at', 'created_at', 'updated_at'];

    public function thread()
    {
        return $this->belongsTo(MessageThread::class, 'thread_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function isUnreadFor($userId)
    {
        // unread if receiver is this user and read_at is null
        return $this->receiver_id === $userId && $this->read_at === null;
    }
}
