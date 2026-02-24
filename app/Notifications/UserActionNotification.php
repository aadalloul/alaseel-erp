<?php

namespace App\Notifications;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class UserActionNotification extends Notification implements ShouldBroadcast
{
    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast']; // مهم جدا
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'message' => $this->message,
            'user' => auth()->user()->name,
        ]);
    }

    public function toArray($notifiable)
    {
        return [
            'message' => $this->message,
            'user' => auth()->user()->name,
        ];
    }
}
