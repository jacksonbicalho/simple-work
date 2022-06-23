<?php declare(strict_types=1);

namespace SimpleWorker\Queue;


use SimpleWorker\Exception\NotFoundException;
use SimpleWorker\RedisTrait;
use Psr\Container\ContainerInterface;

class Queue extends QueueAbstract
{
    use RedisTrait;

    private $config;

    const PRIORITY_LOW = 'low';
    const PRIORITY_MEDIUM = 'medium';
    const PRIORITY_RIGH = 'righ';

    public function __construct(ContainerInterface $container)
    {
        $this->config['redis'] = $container->get('redis');
    }

    public function schedule(string $worker, array $task, string $name = '', string $priority = ''): bool
    {
        if (!class_exists($worker)) {
            new NotFoundException('Classe não encontrada');
        }

        $interfaces = class_implements($worker);
        if (!isset($interfaces['SimpleWorker\Worker\WorkerInterface'])) {
            new NotFoundException('Classe não encontrada');
        }

        $priority = empty($priority) ? self::PRIORITY_LOW : $priority;

        $job = [
            'worker' => $worker,
            'task' => $task,
            'created_at' => date('Y-m-d H:i:s')
        ];
        $queueName = $priority;
        if (!empty($name)) {
            $queueName . "{$name}.{$priority}";
        }
        return (bool) $this->redis()->rpush($queueName, json_encode($job));
    }

    public function run(string $name = '', string $priority = ''): bool
    {
        $priority = empty($priority) ? self::PRIORITY_LOW : $priority;

        $queueName = $priority;
        if (!empty($name)) {
            $queueName . "{$name}.{$priority}";
        }

        $job = $this->redis()->lpop($queueName);
        if (empty($job)) {
            return false;
        }
        $job = json_decode($job);

        $worker = new $job->worker;

        return (bool) $worker->run($job->task);
    }
}