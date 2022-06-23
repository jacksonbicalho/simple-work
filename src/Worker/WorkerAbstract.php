<?php declare(strict_types=1);

namespace SimpleWorker\Worker;

use SimpleWorker\Worker\WorkerInterface;


abstract class WorkerAbstract implements WorkerInterface
{
    public function run(array $job): bool
    {
        return $this->run($job);
    }
}