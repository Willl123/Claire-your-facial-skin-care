<?php

use App\Models\Chat;
use Illuminate\Support\Facades\Broadcast;

// Channel bawaan User
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Channel khusus Admin
Broadcast::channel('admin.bookings', function ($user) {
    return $user->role === 'admin';
});

// Channel khusus Chat Customer dan Worker
Broadcast::channel('chat.{chatId}', function ($user, $chatId) {
    $chat = Chat::find($chatId);

    if (!$chat) {
        return false;
    }

    return (int) $user->id === (int) $chat->customer_id
        || (int) $user->id === (int) $chat->therapist_id;
});
