<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use SimpleWorker\File\SplitFile;
use Psr\Container\NotFoundExceptionInterface;

final class SplitFileTest extends TestCase
{
    public function testNotFoundFile(): void
    {
        $this->expectException(NotFoundExceptionInterface::class);
        $splitFile = new SplitFile('/bla/bla/bla/bla.csv');
    }
}