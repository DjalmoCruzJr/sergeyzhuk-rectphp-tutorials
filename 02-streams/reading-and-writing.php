<?php

require __DIR__ . "/../vendor/autoload.php";

$loop = \React\EventLoop\Factory::create();

// $input = STDIN;
$input = fopen(__DIR__ . '/input.txt', 'r');
$readableStream = new \React\Stream\ReadableResourceStream($input, $loop);

// $output = STDOUT;
$output = fopen(__DIR__ . '/output.txt', 'w');
$writableStream = new \ReactStream\WritableResourceStream($output, $loop);

//Reading and writing data
$readableStream->on('data', function ($data) use ($writableStream){
    echo $data . PHP_EOL;  
    $writableStream->write($data);
});

// Reading and writing finish
$readableStream->on('end', function() use ($writableStream){
    echo "Readable stream end" . PHP_EOL;
    $writableStream->end();
});

$loop->run();

 