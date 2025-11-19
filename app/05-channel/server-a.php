<?php

use Swoole\Coroutine\Channel;
use Swoole\Coroutine;
use Swoole\Http\Server;

$jobs = new Channel(10);

$server = new Server("0.0.0.0", 9501);

$server->on('workerStart', function () use ($jobs) {
    echo 'Worker iniciado!' . PHP_EOL;

    Coroutine::create(function () use ($jobs) {
        while (true) {
            $job = $jobs->pop();
            echo "Processando job: {$job}" . PHP_EOL;
            Coroutine::sleep(1);
        }
    });
});

$server->on("request", function ($request, $response) use ($jobs) {
    if ($request->server['request_uri'] === '/job') {
        $id = uniqid("task_");
        $jobs->push($id);
        $response->end("Job enviado: {$id}");
        return;
    }

    $response->end("Home");
});

$server->start();
