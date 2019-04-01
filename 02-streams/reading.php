<?php

require __DIR__ . "/../vendor/autoload.php";


$loop = \React\EventLoop\Factory::create();

$stream = new \React\Stream\ReadableResourceStream(STOUT, $loop);

$stream->on('data', function ($data) {
    echo $data . PHP_EOL;
});

$stream->on('end', function () {
    echo "Reading is finished!" . PHP_EOL;
});

$loop->run();
