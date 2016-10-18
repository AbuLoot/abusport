<?php

namespace App\Events;

use App\Match;
use App\Events\Event;

use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CreatedNewMatch extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $match;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Match $match)
    {
        
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
