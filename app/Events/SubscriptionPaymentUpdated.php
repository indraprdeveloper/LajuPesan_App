<?php

namespace App\Events;

use App\Models\Subscription;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SubscriptionPaymentUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Subscription $subscription
    ) {}

    public function broadcastOn(): array
    {
        return [
            new Channel('store.' . $this->subscription->user_id),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'subscription_id' => $this->subscription->id,
            'status' => $this->subscription->subscriptionPayment->status ?? 'pending',
        ];
    }
}
