<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use InvalidArgumentException;
use loophp\collection\Collection;
use loophp\collection\Contract\Operation;

/**
 * Class Intersperse.
 *
 * Insert a given value between each element of a collection.
 * Indices are not preserved.
 */
final class Intersperse implements Operation
{
    /**
     * @var int
     */
    private $atEvery;

    /**
     * @var mixed
     */
    private $element;

    /**
     * @var int
     */
    private $startAt;

    /**
     * Intersperse constructor.
     *
     * @param mixed $element
     * @param int $atEvery
     * @param int $startAt
     */
    public function __construct($element, int $atEvery = 1, int $startAt = 0)
    {
        $this->element = $element;
        $this->atEvery = $atEvery;
        $this->startAt = $startAt;
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): Closure
    {
        $element = $this->element;
        $every = $this->atEvery;
        $startAt = $this->startAt;

        if (0 > $every) {
            throw new InvalidArgumentException('The second parameter must be a positive integer.');
        }

        if (0 > $startAt) {
            throw new InvalidArgumentException('The third parameter must be a positive integer.');
        }

        return static function () use ($element, $every, $startAt, $collection): Generator {
            foreach ($collection as $key => $value) {
                if (0 === $startAt++ % $every) {
                    yield $element;
                }

                yield $value;
            }
        };
    }
}
