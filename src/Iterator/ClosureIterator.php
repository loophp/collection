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
     * @param \Closure $closure
     *
     * @throws \ReflectionException
     */
    public function __construct(\Closure $closure)
    {
        $reflection = new \ReflectionFunction($closure);

        if (!$reflection->isGenerator()) {
            $closure = static function () use ($closure) {
                foreach ($closure() as $k => $v) {
                    yield $k => $v;
                }
            };
        }

        $this->source = static function () use ($closure) {
            foreach ($closure() as $k => $v) {
                yield $k => $v;
            }
        };

        $this->generator = $closure();
    }

    /**
     * Return the current element.
     *
     * @see https://php.net/manual/en/iterator.current.php
     *
     * @return mixed Can return any type.
     *
     * @since 5.0.0
     */
    public function current()
    {
        return $this->generator->current();
    }

    /**
     * Return the key of the current element.
     *
     * @see https://php.net/manual/en/iterator.key.php
     *
     * @return mixed scalar on success, or null on failure.
     *
     * @since 5.0.0
     */
    public function key()
    {
        return $this->generator->key();
    }

    /**
     * Move forward to next element.
     *
     * @see https://php.net/manual/en/iterator.next.php
     * @since 5.0.0
     */
    public function next(): void
    {
        $this->generator->next();
    }

    /**
     * Rewind the Iterator to the first element.
     *
     * @see https://php.net/manual/en/iterator.rewind.php
     * @since 5.0.0
     */
    public function rewind(): void
    {
        $this->generator = ($this->source)();
    }

    /**
     * Checks if current position is valid.
     *
     * @see https://php.net/manual/en/iterator.valid.php
     *
     * @return bool The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     *
     * @since 5.0.0
     */
    public function valid()
    {
        return $this->generator->valid();
    }
}
