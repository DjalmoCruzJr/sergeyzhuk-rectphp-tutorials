<?php

require  __DIR__ . "/../vendor/autoload.php";


$loop = \React\EventLoop\Factory::create();

$loop->addTimer(1, function () {
    echo "After Timen" . PHP_EOL;
});


echo "Before Timer" . PHP_EOL;

$loop->run();
