<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{

    public function viewAny(User $user): bool
    {
        //
    }


    public function view(User $user, Order $order): bool
    {
        return $user->id === $order->client_id || $user->role === 'admin';
    }


    public function create(User $user): bool
    {
        return $user->role === 'client';
    }


    public function update(User $user, Order $order): bool
    {
        return $user->role === 'admin' || $user->role === 'logistics';
    }


    public function delete(User $user, Order $order): bool
    {
        return $user->role === 'admin';
    }

    
}
