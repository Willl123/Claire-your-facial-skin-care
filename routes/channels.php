<?php

use App\Models\Chat;
use Illuminate\Support\Facades\Broadcast;

// Channel bawaan User
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Channel khusus Admin untuk booking baru
Broadcast::channel('admin.bookings', function ($user) {
    return $user->role === 'admin';
});

// Channel khusus Admin untuk respons penugasan Worker
Broadcast::channel('admin.assignments', function ($user) {
    return $user->role === 'admin';
});

// Channel khusus Worker untuk penugasan baru
Broadcast::channel('worker.assignments.{workerId}', function ($user, $workerId) {
    return $user->role === 'therapist'
        && (int) $user->id === (int) $workerId;
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

Broadcast::channel('worker.assignments.{workerId}', function ($user, $workerId) {
    return $user->role === 'therapist'
        && (int) $user->id === (int) $workerId;
});



