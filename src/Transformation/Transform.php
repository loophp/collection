<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use loophp\collection\Contract\Transformation;

/**
 * Class Transform.
 */
final class Transform implements Transformation
{
    /**
     * @var \loophp\collection\Contract\Transformation[]
     */
    private $transformers;

    /**
     * Run constructor.
     *
     * @param \loophp\collection\Contract\Transformation ...$transformers
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
        return (
            new FoldLeft(
                static function (iterable $collection, Transformation $transformer) {
                    return $transformer->on($collection);
                },
                $collection
            )
        )->on($this->transformers);
    }
}
