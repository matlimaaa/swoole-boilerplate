<?php

use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;

$ws = new Server('0.0.0.0', 9501);

$ws->on('open', function ($ws, $req) {
    echo "🟢 New connection opening: #{$req->fd}" . PHP_EOL;

    $ws->push($req->fd, json_encode([
        'type' => 'system',
        'text' => 'Welcome to new Chat! Your ID is ' . $req->fd,
    ]));
});

$ws->on('message', function (Server $ws, Frame $frame) {
    echo "💬 Message from #{$frame->fd}: {$frame->data}" . PHP_EOL;

    foreach ($ws->connections as $connection) {
        if (! $ws->isEstablished($connection) || $connection === $frame->fd) continue;

        $ws->push($connection, json_encode([
            'type' => 'chat',
            'from' => $frame->id,
            'text' => $frame->data,
            'time' => date('H:i:s'),
        ]));
    }
});

$ws->on('close', function ($fw, $fd) {
    echo "🔴 Closed connection: {$fd}" . PHP_EOL;
});

$ws->on('request', function ($request, $response) {
    if ($request->server['path_info'] === '/' || $request->server['request_uri'] === '/') {
        $response->header('Content-Type', 'text/html');
        $response->end(file_get_contents(__DIR__ . '/index.html'));
    }
});

$ws->start();
