<?php

namespace AscentCreative\Sandbox\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use AscentCreative\Sandbox\Models\Sandbox;

/**
 * Triggered whenever the Basket model is updated (add / remove items, coupon codes, shipping details etc)
 */
class NewSandbox
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sandbox = null;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Sandbox $sandbox)
    {
        $this->sandbox = $sandbox;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
  /*  public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    } */
}
