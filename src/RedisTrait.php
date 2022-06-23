<?php declare(strict_types=1);

namespace SimpleWorker;

use Redis;

trait RedisTrait
{
    private $_redis = null;

    public function redis()
    {
        $config = $this->config['redis'];
        if (!is_null($this->_redis)) {
            return $this->_redis;
        }

        $this->_redis = new Redis();
        $this->_redis->connect($config['host'], $config['port'], $config['timeout'], $config['reserved']);

        return $this->_redis;
    }
}
