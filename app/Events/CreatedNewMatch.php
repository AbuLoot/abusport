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
        $this->match = $match;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['area-'.$this->match->field->area->id];
    }

    public function broadcastWith()
    {
        return [
            'field_id' => $this->match->field_id,
            'start_time' => $this->match->start_time,
            'end_time' => $this->match->end_time,
            'date' => $this->match->date,
            'match_type' => $this->match->match_type,
        ];
    }

    public function broadcastAs()
    {
        return 'CreatedNewMatch';
    }
}
