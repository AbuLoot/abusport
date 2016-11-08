<?php

namespace App\Events;

use App\User;
use App\Events\Event;

use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class JoinedToMatch extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['match-'.$this->user->pivot->match_id];
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->user->id,
            'fullName' => $this->user->surname.' '.$this->user->name,
            'balance' => $this->user->balance,
            'status' => 1
        ];
    }

    public function broadcastAs()
    {
        return 'JoinedToMatch';
    }
}
