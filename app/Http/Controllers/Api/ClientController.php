<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Cache;


class ClientController extends Controller
{
    public function index()
    {
        $clients = Cache::remember('clients_all', 300, function () {
            return Client::all();
        });

        return response()->json($clients);
    }

    public function store(Request $request)
    {
        $client = Client::create($request->only(['name','email','phone','document','address']));
        Cache::forget('clients_all');
        return response()->json($client, 201);
    }

    public function show($id)
    {
        $client = Cache::remember("client_{$id}", 300, function () use ($id) {
            return Client::with('orders')->findOrFail($id);
        });

        return response()->json($client);
    }
}
