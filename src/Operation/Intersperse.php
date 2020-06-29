<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use InvalidArgumentException;
use loophp\collection\Contract\Operation;

/**
 * Class Intersperse.
 *
 * Insert a given value between each element of a collection.
 * Indices are not preserved.
 */
final class Intersperse extends AbstractOperation implements Operation
{
    /**
     * Intersperse constructor.
     *
     * @param mixed $element
     * @param int $atEvery
     * @param int $startAt
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
        $every = $this->get('atEvery');
        $startAt = $this->get('startAt');

        if (0 > $every) {
            throw new InvalidArgumentException('The second parameter must be a positive integer.');
        }

        if (0 > $startAt) {
            throw new InvalidArgumentException('The third parameter must be a positive integer.');
        }

        return
            /**
             * @param mixed $element
             * @param iterable $collection
             * @param int $every
             * @param int $startAt
             */
            static function (iterable $collection, $element, int $every, int $startAt): Generator {
                foreach ($collection as $value) {
                    if (0 === $startAt++ % $every) {
                        yield $element;
                    }

                    yield $value;
                }
            };
    }
}
