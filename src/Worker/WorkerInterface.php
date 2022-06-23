<?php

namespace SimpleWorker\Worker;


interface WorkerInterface
{
    public function get(string $priority = ''): bool;
    public function run(array $job): bool;
}