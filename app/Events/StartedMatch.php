<?php

namespace App\Events;

use App\Match;
use App\Events\Event;

use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class StartedMatch extends Event implements ShouldBroadcast
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
        return ['area-'.$this->match->field->area_id];
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->match->id,
            'areaId' => $this->match->field->area_id,
            'fieldId' => $this->match->field_id,
            'userId' => $this->match->user_id,
            'startTime' => $this->match->start_time,
            'endTime' => $this->match->end_time,
            'date' => $this->match->date,
            'price' => $this->match->price,
            'matchType' => $this->match->match_type,
            'numberOfPlayers' => $this->match->number_of_players,
            'status' => $this->match->status,
        ];
    }

    public function broadcastAs()
    {
        return 'StartedMatch';
    }
}
