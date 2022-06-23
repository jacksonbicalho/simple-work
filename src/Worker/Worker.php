<?php declare(strict_types=1);

namespace SimpleWorker\Worker;

use SimpleWorker\Exception\NotFoundException;
use SimpleWorker\RedisTrait;
use SimpleWorker\Worker\WorkerAbstract;


class Worker extends WorkerAbstract
{
    use RedisTrait;

    public $config;

    const PRIORITY_LOW = 'low';
    const PRIORITY_MEDIUM = 'medium';
    const PRIORITY_RIGH = 'righ';


    public function get(string $priority = ''): bool
    {
        $priority = empty($priority) ? self::PRIORITY_LOW : $priority;
        $job = json_decode($this->redis()->lpop("jobs.$priority"), true);
        $worker = new $job['worker'];
        $run = $worker->run($job['args']);
        $status = $run ? 'rodado' : 'falhado';
        $this->redis()->hset('worker.status', $job['id'], $status);

        return $run;
    }
}