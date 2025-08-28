<?php

namespace App\Jobs;

use App\Mail\OrderCreatedMail;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendOrderCreatedEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected Order $order;


    public function __construct(Order $order)
    {
        $this->order = $order;
    }


    public function handle(): void
    {
        if ($this->order->client && $this->order->client->email) {
            Mail::to($this->order->client->email)
                ->send(new OrderCreatedMail($this->order));
        }
    }
}
