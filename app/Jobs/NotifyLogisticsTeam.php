<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\LogisticsNotificationMail;
use App\Models\Order;


class NotifyLogisticsTeam implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Order $order; 
    public string $email;


    public function __construct(Order $order, string $email)
    {
        $this->order = $order;
        $this->email = $email;
    }


    public function handle(): void
    {
        if ($this->order && $this->email) {
            Mail::to($this->email)
                ->send(new LogisticsNotificationMail($this->order));
        }
    }
}
