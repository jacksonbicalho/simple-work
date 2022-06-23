<?php

namespace SimpleWorker\Exception;

use Psr\Container\NotFoundExceptionInterface;

/**
 * Class NotFoundException
 * @package DevCoder\DependencyInjection\Exception
 */
class NotFoundException extends \InvalidArgumentException implements NotFoundExceptionInterface
{
}