<?php

declare(strict_types=1);

namespace drupol\collection\Iterator;

/**
 * Class ClosureIterator.
 */
class ClosureIterator implements \Iterator
{
    /**
     * @var \Generator
     */
    private $generator;

    /**
     * @var \Closure
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
            foreach ($callable(...$arguments) as $key => $value) {
                yield $key => $value;
            }
        };
    }

    /**
     * {@inheritdoc}
     *
     * @return mixed
     */
    public function current()
    {
        $this->initGenerator();

        return $this->generator->current();
    }

    /**
     * {@inheritdoc}
     *
     * @return int|string
     */
    public function key()
    {
        $this->initGenerator();

        return $this->generator->key();
    }

    /**
     * {@inheritdoc}
     *
     * @return $this|void
     */
    public function next()
    {
        $this->initGenerator();

        $this->generator->next();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function rewind(): void
    {
        $this->initGenerator();
    }

    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function valid()
    {
        $this->initGenerator();

        return $this->generator->valid();
    }

    /**
     * Init the generator if not initialized yet.
     */
    private function initGenerator(): void
    {
        if (null === $this->generator) {
            $this->generator = ($this->source)();
        }
    }
}
