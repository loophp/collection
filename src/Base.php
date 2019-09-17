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
     * @param mixed ...$parameters
     */
    public function __construct($data = [], ...$parameters)
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
                $parameters += [0 => null];
                $separator = (string) $parameters[0];

                $this->source = static function () use ($data, $separator) {
                    $offset = 0;

                    $nextOffset = '' !== $separator ?
                        \mb_strpos($data, $separator, $offset) :
                        1;

                    while (\mb_strlen($data) > $offset && false !== $nextOffset) {
                        yield \mb_substr($data, $offset, $nextOffset - $offset);
                        $offset = $nextOffset + \mb_strlen($separator);

                        $nextOffset = '' !== $separator ?
                            \mb_strpos($data, $separator, $offset) :
                            $nextOffset + 1;
                    }

                    if ('' !== $separator) {
                        yield \mb_substr($data, $offset);
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
        return new static((new Run(...$operations))->on($this));
    }

    /**
     * {@inheritdoc}
     */
    public function transform(Transformer ...$transformers)
    {
        return (new Transform(...$transformers))->on($this);
    }
}
