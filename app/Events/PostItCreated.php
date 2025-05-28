<?php

namespace App\Events;

use App\Models\PostIt;
use App\Http\Resources\PostItResource;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class PostItCreated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public function __construct(public PostIt $postIt) {}

    public function broadcastOn(): Channel
    {
        return new PrivateChannel('post-its');
    }

    public function broadcastWith(): array
    {
        return ['postIt' => new PostItResource($this->postIt)];
    }
}
