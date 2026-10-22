<?php

namespace App\Observers;

use App\Models\Transaction;
use App\Notifications\LowBalanceNotification;
use Exception;

class AccountObserver
{
    // Runs BEFORE a transaction is saved: update balance or block
    public function creating(Transaction $transaction): void
    {
        $account = $transaction->account;

        if ($transaction->type === 'deposit') {
            $account->balance += $transaction->amount;
        } else {
            $newBalance = $account->balance - $transaction->amount;

            if ($newBalance < $account->minimum_balance) {
                throw new Exception("Insufficient funds. Balance cannot fall below the minimum balance of {$account->minimum_balance}.");
            }

            $account->balance = $newBalance;
        }

        $account->save();
    }

    // Runs AFTER a transaction is saved: low balance alert
    public function created(Transaction $transaction): void
    {
        // Only after a withdrawal / transfer
        if ($transaction->type === 'deposit') {
            return;
        }

        $account = $transaction->account;

        // balance <= minimum_balance ?
        if ($account->balance > $account->minimum_balance) {
            return;
        }

        $user = $account->user;

        // Prevent duplicates: skip if an unread low-balance alert already exists for this account
        $alreadyNotified = $user->unreadNotifications
            ->where('type', LowBalanceNotification::class)
            ->contains(fn ($n) => ($n->data['account_id'] ?? null) === $account->id);

        if (! $alreadyNotified) {
            $user->notify(new LowBalanceNotification($account));
        }
    }
}