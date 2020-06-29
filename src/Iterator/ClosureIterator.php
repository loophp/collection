<?php

declare(strict_types=1);

namespace loophp\collection\Iterator;

use Generator;
use Iterator;

/**
 * Class ClosureIterator.
 *
 * @implements Iterator<mixed>
 */
final class ClosureIterator implements Iterator
{
    /**
     * @var array<mixed>
     */
    private $arguments;

    /**
     * @var callable
     */
    private $callable;

    /**
     * @var Generator<Generator<mixed>>|null
     */
    private $generator;

    /**
     * ClosureIterator constructor.
     *
     * @param mixed ...$arguments
     * @param callable $callable
     */
    public function __construct(callable $callable, ...$arguments)
    {
        $this->callable = $callable;
        $this->arguments = $arguments;
    }

    /**
     * {@inheritdoc}
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
     * @return void
     */
    public function next()
    {
        $this->getGenerator()->next();
    }

    public function rewind(): void
    {
        $this->generator = null;
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
        if (null === $this->generator) {
            $this->generator = (
                static function (callable $callable, array $arguments): Generator {
                    yield from ($callable)(...$arguments);
                }
            )($this->callable, $this->arguments);
        }

        return $this->generator;
    }
}
