<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Iterator\ClosureIterator;

/**
 * Class Chunk.
 */
final class Chunk extends Operation
{
    /**
     * Chunk constructor.
     *
     * @param int $size
     */
    public function __construct(int $size)
    {
        parent::__construct(...[$size]);
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): \Closure
    {
        [$size] = $this->parameters;

        if (0 >= $size) {
            return static function (): \Generator {
                yield from [];
            };
        }

        return static function () use ($size, $collection): \Generator {
            $iterator = new ClosureIterator(
                static function () use ($collection) {
                    foreach ($collection as $key => $value) {
                        yield $key => $value;
                    }
                }
            );

            while ($iterator->valid()) {
                $values = [];

                for ($i = 0; $iterator->valid() && $i < $size; $i++, $iterator->next()) {
                    $values[$iterator->key()] = $iterator->current();
                }

                yield new \ArrayIterator($values);
            }
        };
    }
}
