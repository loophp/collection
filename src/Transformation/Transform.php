<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use Iterator;
use loophp\collection\Contract\Transformation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements Transformation<TKey, T>
 */
final class Transform extends AbstractTransformation implements Transformation
{
    /**
     * @param \loophp\collection\Contract\Transformation<TKey, T> ...$transformers
     */
    public function __construct(Transformation ...$transformers)
    {
        $this->storage['transformers'] = $transformers;
    }

    public function __invoke()
    {
        return function (Iterator $collection) {
            return array_reduce(
                $this->get('transformers', []),
                static function (Iterator $collection, Transformation $transformer) {
                    return ($transformer)()(
                        $collection,
                        ...array_values($transformer->getArguments())
                    );
                },
                $collection
            );
        };
    }
}
