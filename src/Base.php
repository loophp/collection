<?php

declare(strict_types=1);

namespace drupol\collection;

use drupol\collection\Contract\Base as BaseInterface;
use drupol\collection\Contract\Operation;
use drupol\collection\Contract\Transformer;
use drupol\collection\Iterator\ClosureIterator;
use drupol\collection\Transformation\Run;
use drupol\collection\Transformation\Transform;

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
                    foreach ($data as $key => $value) {
                        yield $key => $value;
                    }
                };

                break;
            case \is_string($data):
                $this->source = static function () use ($data) {
                    foreach (mb_str_split($data) as $key => $value) {
                        yield $key => $value;
                    }
                };

                break;

            default:
                $this->source = static function () use ($data) {
                    foreach ((array) $data as $key => $value) {
                        yield $key => $value;
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
     * {@inheritdoc}
     */
    public function run(Operation ...$operations)
    {
        return (new Run(...$operations))->on($this);
    }

    /**
     * {@inheritdoc}
     */
    public function transform(Transformer ...$transformers)
    {
        return (new Transform(...$transformers))->on($this);
    }
}
