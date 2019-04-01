<?php

require __DIR__ .  "/../vendor/autoload.php";

function http($url, $method)
{
    $response = "Data";
    $deferred = new \React\Promise\Deferred();

    if ($response) {
        $deferred->resolve($response);
    } else {
        $deferred->reject(new \Exception('No response'));
    }

    return $deferred->promise();
}

http('http://google.com', 'GET')
    ->then(function ($response) {
        return strtoupper($response);
    })
    ->then(function ($response) {
        echo $response . PHP_EOL;
    })
    ->otherwise(function (\Exception $e) {
        echo $e->getMessage() . PHP_EOL;
    });
