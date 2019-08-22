<?php

declare(strict_types=1);

namespace drupol\collection;

use drupol\collection\Contract\BaseCollection as BaseCollectionInterface;

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
            case $data instanceof \IteratorAggregate:
            case $data instanceof \Traversable:
                $this->source = static function () use ($data) {
                    yield from \iterator_to_array(
                        (static function () use ($data) {
                            yield from $data;
                        })()
                    );
                };

                break;

            default:
                $this->source = static function () use ($data) {
                    yield from (array) $data;
                };
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return ($this->source)();
    }

    /**
     * {@inheritdoc}
     */
    public static function with($data = []): BaseCollectionInterface
    {
        return new static($data);
    }
}
