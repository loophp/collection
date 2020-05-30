<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;

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
    public function __invoke(): Closure
    {
        $length = $this->length;

        return static function (iterable $collection) use ($length): Generator {
            if (0 >= $length) {
                return yield from [];
            }

            $values = [];

            foreach ($collection as $value) {
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
