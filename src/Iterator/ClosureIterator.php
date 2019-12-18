<?php

declare(strict_types=1);

namespace drupol\collection\Iterator;

use Closure;
use Generator;
use Iterator;

/**
 * Class ClosureIterator.
 *
 * @implements Iterator<Iterator>
 */
final class ClosureIterator implements Iterator
{
    /**
     * @var Generator<callable>|null
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
     * @param array<mixed> ...$arguments
     */
    public function __construct(callable $callable, ...$arguments)
    {
        $this->source = static function () use ($callable, $arguments): Generator {
            yield from $callable(...$arguments);
        };
    }

    /**
     * @return Iterator<mixed>
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
     * @return Generator<Generator<mixed>>
     */
    private function getGenerator(): Generator
    {
        $this->generator = $this->generator ?? ($this->source)();

        return $this->generator;
    }
}
