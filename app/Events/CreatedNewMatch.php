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
    public $area_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Match $match, $area_id)
    {
        $this->match = $match;
        $this->area_id = $area_id;
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

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['chat-'.$this->message->match_id];
    }

    public function broadcastWith()
    {
        return [
            'user_id' => $this->message->user_id,
            'fullname' => Auth::user()->surname.' '.Auth::user()->name,
            'message' => $this->message->message,
            'created_at' => $this->message->created_at
        ];
    }

    public function broadcastAs()
    {
        return 'AddedNewMessage';
    }
}
