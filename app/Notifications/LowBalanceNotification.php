<?php

namespace App\Notifications;

use App\Models\Account;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LowBalanceNotification extends Notification
{
    use Queueable;

    public function __construct(public Account $account)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message'        => 'Warning: Your account balance is low.',
            'account_id'     => $this->account->id,
            'account_number' => $this->account->account_number,
            'balance'        => $this->account->balance,
        ];
    }
}