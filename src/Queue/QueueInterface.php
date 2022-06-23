<?php declare(strict_types=1);

namespace SimpleWorker\Queue;


interface QueueInterface
{
    public function schedule(string $worker, array $task, string $name = '', string $priority = ''): bool;

    public function run(string $priority = ''): bool;
}