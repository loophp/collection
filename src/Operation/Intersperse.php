<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Collection;

/**
 * Class Intersperse.
 *
 * Insert a given value between each element of a collection.
 * Indices are not preserved.
 */
final class Intersperse extends Operation
{
    /**
     * Intersperse constructor.
     *
     * @param mixed $elementToIntersperse
     * @param int $atEvery
     * @param int $startAt
     */
    public function __construct($elementToIntersperse, int $atEvery = 1, int $startAt = 0)
    {
        parent::__construct(...[$elementToIntersperse, $atEvery, $startAt]);
    }

    /**
     * {@inheritdoc}
     */
    public function on(\Traversable $collection): \Closure
    {
        [$element, $every, $startAt] = $this->parameters;

        if (0 > $every) {
            throw new \InvalidArgumentException('The second parameter must be a positive integer.');
        }

        if (0 > $startAt) {
            throw new \InvalidArgumentException('The third parameter must be a positive integer.');
        }

        return static function () use ($element, $every, $startAt, $collection): \Generator {
            foreach ($collection as $key => $value) {
                if (0 === $startAt++ % $every) {
                    yield $element;
                }

                yield $value;
            }
        };
    }
}
