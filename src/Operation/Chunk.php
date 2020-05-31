<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Collection;
use loophp\collection\Contract\Operation;
use loophp\collection\Iterator\IterableIterator;

use function count;

/**
 * Class Chunk.
 */
final class Chunk implements Operation
{
    /**
     * @var array<int, int>
     */
    private $size;

    /**
     * Chunk constructor.
     *
     * @param array<int, int> $size
     */
    public function __construct(int ...$size)
    {
        $this->size = $size;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(): Closure
    {
        $size = $this->size;

        return static function (iterable $collection) use ($size): Generator {
            $size = new IterableIterator((new Collection($size))->loop());

            $values = [];

            foreach ($collection as $value) {
                if (0 >= $size->current()) {
                    return yield from [];
                }

                if (count($values) === $size->current()) {
                    $size->next();

                    yield $values;

                    $values = [$value];
                } else {
                    $values[] = $value;
                }
            }

            yield $values;
        };
    }
}
