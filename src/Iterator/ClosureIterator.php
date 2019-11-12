<?php

declare(strict_types=1);

namespace drupol\collection\Iterator;

use Closure;
use Generator;
use Iterator;

/**
 * Class ClosureIterator.
 */
final class ClosureIterator implements Iterator
{
    /**
     * @var Generator|null
     */
    private $generator;

    /**
     * @var Closure
     */
    private $source;

    /**
     * ClosureIterator constructor.
     *
     * @param callable $callable
     * @param array ...$arguments
     */
    public function __construct(callable $callable, ...$arguments)
    {
        $this->source = static function () use ($callable, $arguments) {
            yield from $callable(...$arguments);
        };
    }

    /**
     * {@inheritdoc}
     *
     * @return mixed
     */
    public function current()
    {
        return $this->getGenerator()->current();
    }

    /**
     * {@inheritdoc}
     *
     * @return int|string
     */
    public function key()
    {
        return $this->getGenerator()->key();
    }

    /**
     * {@inheritdoc}
     *
     * @return $this
     */
    public function next()
    {
        $this->getGenerator()->next();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function rewind(): void
    {
        $this->getGenerator();
    }

    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function valid()
    {
        return $this->getGenerator()->valid();
    }

    /**
     * Init the generator if not initialized yet.
     *
     * @return Generator
     */
    private function getGenerator(): Generator
    {
        $this->generator = $this->generator ?? ($this->source)();

        return $this->generator;
    }
}
