<?php

declare(strict_types=1);

namespace drupol\collection;

use drupol\collection\Contract\Base as BaseInterface;
use drupol\collection\Iterator\ClosureIterator;

/**
 * Class Base.
 */
abstract class Base implements BaseInterface
{
    /**
     * @var \Closure
     */
    protected $source;

    /**
     * Base constructor.
     *
     * @param \Closure|iterable|mixed $data
     */
    public function __construct($data = [])
    {
        switch (true) {
            case $data instanceof \Closure:
                $this->source = $data;

                break;
            case \is_iterable($data):
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
     */
    public function getIterator(): ClosureIterator
    {
        return new ClosureIterator($this->source);
    }

    /**
     * @param array $data
     *
     * @return \drupol\collection\Contract\Base
     */
    public static function with($data = []): BaseInterface
    {
        return new static($data);
    }
}
