<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Collection;
use loophp\collection\Contract\Operation;
use loophp\collection\Iterator\IterableIterator;

use function count;

final class Chunk extends AbstractOperation implements Operation
{
    /**
     * Chunk constructor.
     *
     * @param int ...$size
     */
    public function __construct(int ...$size)
    {
        $this->storage['size'] = $size;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(): Closure
    {
        return static function (iterable $collection, array $sizes): Generator {
            $sizes = new IterableIterator(
                (new Collection($sizes))->loop()
            );

            $values = [];

            foreach ($collection as $value) {
                if (0 >= $sizes->current()) {
                    return yield from [];
                }

                if (count($values) !== $sizes->current()) {
                    $values[] = $value;

                    continue;
                }

                $sizes->next();

                yield $values;

                $values = [$value];
            }

            yield $values;
        };
    }
}
