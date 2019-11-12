<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use ArrayIterator;
use Closure;
use drupol\collection\Contract\Operation;
use drupol\collection\Iterator\ClosureIterator;
use Generator;

/**
 * Class Chunk.
 */
final class Chunk implements Operation
{
    /**
     * @var int
     */
    private $length;

    /**
     * Chunk constructor.
     *
     * @param int $length
     */
    public function __construct(int $length)
    {
        $this->length = $length;
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): Closure
    {
        $length = $this->length;

        if (0 >= $length) {
            return static function (): Generator {
                yield from [];
            };
        }

        return static function () use ($length, $collection): Generator {
            $iterator = new ClosureIterator(
                static function () use ($collection) {
                    foreach ($collection as $key => $value) {
                        yield $value;
                    }
                }
            );

            while ($iterator->valid()) {
                $values = [];

                for ($i = 0; $iterator->valid() && $i < $length; $i++, $iterator->next()) {
                    $values[] = $iterator->current();
                }

                yield new ArrayIterator($values);
            }
        };
    }
}
