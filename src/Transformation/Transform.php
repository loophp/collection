<?php

declare(strict_types=1);

namespace drupol\collection\Transformation;

use drupol\collection\Contract\Transformation;

/**
 * Class Transform.
 */
final class Transform implements Transformation
{
    /**
     * @var \drupol\collection\Contract\Transformation[]
     */
    private $transformers;

    /**
     * Run constructor.
     *
     * @param \drupol\collection\Contract\Transformation ...$transformers
     */
    public function __construct(Transformation ...$transformers)
    {
        $this->transformers = $transformers;
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection)
    {
        $callback = static function (iterable $collection, Transformation $transformer) {
            return $transformer->on($collection);
        };

        return (new Reduce($callback, $collection))->on($this->transformers);
    }
}
