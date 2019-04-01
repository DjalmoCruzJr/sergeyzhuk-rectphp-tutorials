<?php

require __DIR__ . "/../vendor/autoload.php";

$loop = \React\EventLoop\Factory::create();

$host = '127.0.0.1';
$port = '8200';
$url = "{$host}:{$port}";

$server = new \React\Socket\Server($url, $loop);
echo "Server was started on {$server->getAddress()}..." . PHP_EOL;

$server->on('connection', function (\React\Socket\ConnectionInterface $conn) {
    echo "[{$conn->getRemoteAddress()}]:  New client was connected..." . PHP_EOL;
    $conn->write("[Sever]: Successfuly connected!" . PHP_EOL);

    $message = '';
    $conn->on('data', function ($data) use ($conn, &$message) {
        if (!empty($data) && !preg_match('/[\n\r\t]/', $data)) {
            // $message .= trim(preg_replace('/[\r\t]/', (string)' ', $data));
            $message .= trim($data);
            return;
        }

        if (!empty($data) && preg_match('/[\n]/', $data) && !empty($message)) {
            echo "[{$conn->getRemoteAddress()}]: {$message}" . PHP_EOL;
            $message = '';
            return;
        }
    });
});

$loop->run();
