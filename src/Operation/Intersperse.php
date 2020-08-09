<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use InvalidArgumentException;
use Iterator;
use loophp\collection\Contract\Operation;

/**
 * Class Intersperse.
 *
 * Insert a given value between each element of a collection.
 * Indices are not preserved.
 *
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Intersperse extends AbstractGeneratorOperation implements Operation
{
    /**
     * @param mixed $element
     * @psalm-param T $element
     */
    public function __construct($element, int $atEvery = 1, int $startAt = 0)
    {
        $this->storage = [
            'element' => $element,
            'atEvery' => $atEvery,
            'startAt' => $startAt,
        ];
    }

    public function __invoke(): Closure
    {
        /** @var int $every */
        $every = $this->get('atEvery');
        /** @var int $startAt */
        $startAt = $this->get('startAt');

        if (0 > $every) {
            throw new InvalidArgumentException('The second parameter must be a positive integer.');
        }

        if (0 > $startAt) {
            throw new InvalidArgumentException('The third parameter must be a positive integer.');
        }

        return
            /**
             * @psalm-param \Iterator<TKey, T> $iterator
             *
             * @param mixed $element
             * @psalm-param T $element
             *
             * @psalm-return \Generator<int|TKey, T>
             */
            static function (Iterator $iterator, $element, int $every, int $startAt): Generator {
                foreach ($iterator as $key => $value) {
                    if (0 === $startAt++ % $every) {
                        yield $element;
                    }

                    yield $key => $value;
                }
            };
    }
}
