#!/usr/bin/php -q
<?php

require_once dirname(__DIR__, 4) . '/autoload.php';


$config = require(dirname(__DIR__, 5) . '/config/app.php');

use SimpleWorker\Queue\Queue;
use SimpleWorker\Container;


$container = new Container($config);
$queue = new Queue($container);

while (true) {
    sleep(5);
    $queue->run();
}
