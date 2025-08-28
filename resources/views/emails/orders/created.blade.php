<x-mail::message>
# Introduction

**{{ $order->client->name }}** Hemos generado tu orden por un **Total** de ${{ $order->total }}


<x-mail::button :url="'/orders/{$order->id}'">
Ver Orden
</x-mail::button>

Gracias por elegirnos,<br>
{{ config('app.name') }}
</x-mail::message>
