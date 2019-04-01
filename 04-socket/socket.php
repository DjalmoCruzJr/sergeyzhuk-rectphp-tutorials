<?php

require __DIR__ . "/../vendor/autoload.php";

$loop = \React\EventLoop\Factory::create();

$server = new \React\Socket\Server('127.0.0.1:8200', $loop);
$server->on('connection', function (\React\Socket\ConnectionInterface $conn) {
    echo "[{$conn->getRemoteAddress()}]:  New client is connected..." . PHP_EOL;
    $conn->write("[Sever]: Successfuly connected!" . PHP_EOL);
});

$loop->run();
