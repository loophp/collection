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
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @template U
 * @extends AbstractOperation<TKey, T, Generator<int|TKey, T|U>>
 * @implements Operation<TKey, T, Generator<int|TKey, T|U>>
 */
final class Intersperse extends AbstractOperation implements Operation
{
    /**
     * Intersperse constructor.
     *
     * @param U $element
     */
    public function __construct($element, int $atEvery = 1, int $startAt = 0)
    {
        $this->storage = [
            'element' => $element,
            'atEvery' => $atEvery,
            'startAt' => $startAt,
        ];
    }

    /**
     * @return Closure(\Iterator<TKey, T>, U, int, int): Generator<int|TKey, T|U>
     */
    public function __invoke(): Closure
    {
        /** @psalm-var int $every */
        $every = $this->get('atEvery');
        /** @psalm-var int $startAt */
        $startAt = $this->get('startAt');

        if (0 > $every) {
            throw new InvalidArgumentException('The second parameter must be a positive integer.');
        }

        if (0 > $startAt) {
            throw new InvalidArgumentException('The third parameter must be a positive integer.');
        }

        return
            /**
             * @todo yield on $key and $value
             *
             * @param Iterator<TKey, T> $iterator
             * @param U $element
             *
             * @return Generator<int|TKey, T|U>
             */
            static function (Iterator $iterator, $element, int $every, int $startAt): Generator {
                foreach ($iterator as $value) {
                    if (0 === $startAt++ % $every) {
                        yield $element;
                    }

                    yield $value;
                }
            };
    }
}
