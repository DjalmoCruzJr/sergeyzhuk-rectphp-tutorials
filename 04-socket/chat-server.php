<?php

require __DIR__ . "/../vendor/autoload.php";
require __DIR__ . '/ConnectionsPool.php';

use \React\Socket\ConnectionInterface;

$loop = \React\EventLoop\Factory::create();

$host = '127.0.0.1';
$port = '8200';
$url = "{$host}:{$port}";

$pool = new ConnectionsPool();

$server = new \React\Socket\Server($url, $loop);
$server->on('connection', function (ConnectionInterface $conn) use ($pool) {
    $pool->add($conn);
});

$loop->run();
