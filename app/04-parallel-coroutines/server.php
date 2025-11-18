<?php

use Swoole\Coroutine;
use Swoole\Http\Server;

$server = new Server('0.0.0.0', 9501);

$server->on('request', function ($request, $response) {
    $start = microtime(true);

    $taskOne = Coroutine::create(function () {
        Coroutine::sleep(2);
        return 'task 1 done';
    });

    $taskTwo = Coroutine::create(function () {
        Coroutine::sleep(2);
        return 'task 2 done';
    });

    $results = Coroutine::join([$taskOne, $taskTwo]);

    $duration = round(microtime(true) - $start, 2);

    $response->header('Content-Type', 'application/json');
    $response->end(json_encode([
        'time' => $duration . 's',
        'results' => $results
    ], JSON_PRETTY_PRINT));
});

$server->start();
