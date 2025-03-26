<?php

namespace App\Events;

use App\Models\Product;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $product;

    public function __construct($product)
    {
        $this->product = $product;
    }

    public function broadcastOn()
    {
        return ['product']; // Canal público
    }

    // Opcional: Personalizar el nombre del evento
    public function broadcastAs()
    {
        return 'my-product';
    }

}
