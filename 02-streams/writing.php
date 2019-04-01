<?php

require __DIR__ . "/../vendor/autoload.php";


$loop = \React\EventLoop\Factory::create();

$stream = new \React\Stream\ReadableResourceStream(STOUT, $loop);

$stream->write('Hello Wrold!' . PHP_EOL);

$stream->end();

$loop->run();
