<?php

function statusRoute($response) {
    $response->header('Content-Type', 'application/json');
    $response->end(json_encode(["status" => "ok", "time" => date("c")]));
}

function routeNotFound($response) {
    $response->status(404);
    $response->end('Not Found');
}

$server = new Swoole\Http\Server("0.0.0.0", 9501);

$server->on('request', function ($request, $response) {
    $path = $request->server['request_uri'] ?? '/';

    match ($path) {
        '/' => $response->end('Home'),
        '/status' => statusRoute($response),
        default => routeNotFound($response),
    };
});

$server->start();
