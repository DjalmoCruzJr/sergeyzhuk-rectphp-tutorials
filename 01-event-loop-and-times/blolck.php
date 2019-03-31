<?php

require __DIR__ . "/../vendor/autoload.php";

$loop = \React\EventLoop\Factory::create();


$counter = 0;
$loop->addPeriodicTimer(1, function (\React\EventLoop\TimerInterface $timer) use (&$counter, $loop) {
    if ($counter >= 5) {
        $loop->cancelTimer($timer);
    }
    echo "Periodic Timer" . PHP_EOL;
    $counter++;
});


$loop->addTimer(1, function ($i) {
    sleep(5);
    echo "Delay Time" . PHP_EOL;
});

$loop->run();
