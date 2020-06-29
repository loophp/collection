<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use loophp\collection\Contract\Transformation;

final class Transform implements Transformation
{
    /**
     * @var array<int, \loophp\collection\Contract\Transformation>
     */
    private $transformers;

    public function __construct(Transformation ...$transformers)
    {
        $this->transformers = $transformers;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(iterable $collection)
    {
        return (new FoldLeft(
            /** @return mixed */
            static function (iterable $collection, Transformation $transformer) {
                return $transformer($collection);
            },
            $collection
        ))($this->transformers);
    }
}
