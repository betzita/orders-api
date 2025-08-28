<?php

namespace App\Traits;

use App\Mail\OrderCreatedMail;
use App\Mail\NotifyLogisticsMail;
use Illuminate\Support\Facades\Mail;

trait Notifies
{
    /**
     * Notifica al cliente la creación de la orden
     */
    public function notifyCustomer($order)
    {
        if ($order->client && $order->client->email) {
            \App\Jobs\SendOrderCreatedEmail::dispatch($order);
        }
    }

    /**
     * Notifica al equipo de logística
     */
    public function notifyLogistics($order, array $emails)
    {
        foreach ($emails as $email) {
            \App\Jobs\NotifyLogisticsTeam::dispatch($order, $email);
        }
    }
}
