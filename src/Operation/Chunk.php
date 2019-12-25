<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use Closure;
use drupol\collection\Contract\Operation;
use Generator;

use function count;

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
            $values = [];

            foreach ($collection as $key => $value) {
                if (count($values) === $length) {
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
