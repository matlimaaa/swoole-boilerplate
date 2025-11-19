<?php

use Swoole\Coroutine\Channel;
use Swoole\Coroutine;
use Swoole\Http\Server;

$queue = new Channel(10);

$server = new Server("0.0.0.0", 9501);
$coroutineCount = 5;

$server->on('workerStart', function () use ($queue, $coroutineCount) {
    echo 'Iniciando workers!' . PHP_EOL;

    for ($i = 0; $i < $coroutineCount; $i++) {
        echo "WORKER #{$i}" . PHP_EOL;

        Coroutine::create(function () use ($queue, $i) {
            while (true) {
                $job = $queue->pop();
                echo "coroutine #{$i} - Processando job: {$job}" . PHP_EOL;
                Coroutine::sleep(1);
            }
        });
    }
});

$server->on("request", function ($request, $response) use ($queue) {
    if ($request->server['request_uri'] === '/job') {
        $id = uniqid("task_");
        $queue->push($id);
        $response->end("Job enviado: {$id}");
        return;
    }

    $response->end("Home");
});

$server->start();
