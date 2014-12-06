<?php

use React\EventLoop\Factory;
use Clue\React\Shell\ProcessLauncher;

require __DIR__ . '/../vendor/autoload.php';

$loop = Factory::create();
$launcher = new ProcessLauncher($loop);

$shell = $launcher->createDeferredShell('bash 2>&1');

$shell->execute('echo -n $USER')->then(function ($result) {
    var_dump('current user', $result);
});

$shell->execute('env | sort | head -n10')->then(function ($env) {
    var_dump('env', $env);
});

$shell->end();

$loop->run();
