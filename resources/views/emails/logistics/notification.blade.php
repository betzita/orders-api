<x-mail::message>
# Introduction

Se ha creado una nueva orden.

**Cliente:** {{ $order->client->name }}  
**Direccion de entrega:** {{ $order->client->address }}  
**Contacto:** {{ $order->client->phone }}  
**Total:** ${{ $order->total }}  
**Productos:**
@foreach($order->items as $item)
- {{ $item->product->name }} x {{ $item->quantity }}
@endforeach

<x-mail::button :url="''">
PREPARADO
</x-mail::button>

<br>
{{ config('app.name') }}
</x-mail::message>
