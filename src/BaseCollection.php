<?php

declare(strict_types=1);

namespace drupol\collection;

use drupol\collection\Contract\BaseCollection as BaseCollectionInterface;
use drupol\collection\Iterator\ClosureIterator;

/**
 * Class BaseCollection.
 */
abstract class BaseCollection implements BaseCollectionInterface
{
    /**
     * @var \Closure
     */
    protected $source;

    /**
     * BaseCollection constructor.
     *
     * @param mixed $data
     */
    public function __construct($data = [])
    {
        switch (true) {
            case $data instanceof \Closure:
                $this->source = $data;

                break;
            case $data instanceof \Traversable:
                $this->source = static function () use ($data) {
                    foreach ($data as $k => $v) {
                        yield $k => $v;
                    }
                };

                break;

            default:
                $this->source = static function () use ($data) {
                    foreach ((array) $data as $k => $v) {
                        yield $k => $v;
                    }
                };
        }
    }

    /**
     * {@inheritdoc}
     *
     * @throws \ReflectionException
     */
    public function getIterator(): ClosureIterator
    {
        return new ClosureIterator($this->source);
    }
}
