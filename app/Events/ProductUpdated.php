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

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function broadcastOn()
    {
        return new Channel('products'); // Canal público
    }

    // Opcional: Personalizar el nombre del evento
    public function broadcastAs()
    {
        return 'product.updated';
    }

    // Opcional: Personalizar datos enviados
    public function broadcastWith()
    {
        return [
            'product' => $this->product->toArray(),
            'message' => 'Product updated!'
        ];
    }
}
