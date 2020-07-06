<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;
use loophp\collection\Iterator\IterableIterator;
use loophp\collection\Transformation\Run;

use function count;

final class Chunk extends AbstractOperation implements Operation
{
    public function __construct(int ...$size)
    {
        $this->storage['size'] = $size;
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @param array<int, int> $sizes
             */
            static function (iterable $collection, array $sizes): Generator {
                $sizesIterator = new IterableIterator(
                    (new Run(new Loop()))($sizes)
                );

                $values = [];

                foreach ($collection as $value) {
                    if (0 >= $sizesIterator->current()) {
                        return yield from [];
                    }

                    if (count($values) !== $sizesIterator->current()) {
                        $values[] = $value;

                        continue;
                    }

                    $sizesIterator->next();

                    yield $values;

                    $values = [$value];
                }

                return yield $values;
            };
    }
}
