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
        if (null === $this->generator) {
            $this->rewind();
        }

        return $this->generator->current();
    }

    /**
     * {@inheritdoc}
     *
     * @return int|string
     */
    public function key()
    {
        if (null === $this->generator) {
            $this->rewind();
        }

        return $this->generator->key();
    }

    /**
     * {@inheritdoc}
     *
     * @return $this|void
     */
    public function next()
    {
        if (null === $this->generator) {
            $this->rewind();
        }

        $this->generator->next();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function rewind(): void
    {
        $this->generator = ($this->source)();
    }

    /**
     * Send a value to the inner Generator.
     *
     * @param null|mixed $value
     *
     * @return mixed
     */
    public function send($value = null)
    {
        if (null === $this->generator) {
            $this->rewind();
        }

        return $this->generator->send($value);
    }

    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function valid()
    {
        if (null === $this->generator) {
            $this->rewind();
        }

        return $this->generator->valid();
    }
}
