<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\Feedback;

class ComplaintCompletedNotification extends Notification
{
    use Queueable;

    public $complaint;
    public $userName;

    public function __construct(Feedback $complaint)
    {
        $this->complaint = $complaint;
        $this->userName = $complaint->name;
    }

    public function via($notifiable)
    {
        return ['database']; // store in DB
    }

    public function toDatabase($notifiable)
    {
        return [
            'complaint_id' => $this->complaint->id,
            'unique_id' => $this->complaint->unique_id,
            'message' => "Complaint marked complete by user: {$this->userName}",
        ];
    }
}
