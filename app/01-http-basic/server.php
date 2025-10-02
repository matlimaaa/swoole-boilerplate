<?php

$server = new Swoole\Http\Server("0.0.0.0", 9501);

$server->on("start", function () {
    echo "Servidor rodando em http://127.0.0.1:9501\n";
});

$server->on("request", function ($req, $res) {
    $res->end("Hello Swoole! " . date("H:i:s"));
});

$server->start();
