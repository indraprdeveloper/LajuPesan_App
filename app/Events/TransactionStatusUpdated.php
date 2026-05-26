<?php

namespace App\Events;

use App\Models\Transaction;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TransactionStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Transaction $transaction
    ) {}

    public function broadcastOn(): array
    {
        return [
            new Channel('store.' . $this->transaction->user_id),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'transaction_id' => $this->transaction->id,
            'code' => $this->transaction->code,
            'status' => $this->transaction->status,
            'payment_method' => $this->transaction->payment_method,
            'name' => $this->transaction->name,
        ];
    }
}
