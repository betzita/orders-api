<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasOrderTotal;


class Order extends Model
{
    use HasFactory, HasOrderTotal;

    protected $fillable = ['client_id', 'shipping_address', 'billing_address', 'total'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
