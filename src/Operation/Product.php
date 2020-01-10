<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;
use loophp\collection\Iterator\IterableIterator;

use function count;

/**
 * Class Product.
 */
final class Product implements Operation
{
    /**
     * @var iterable[]
     */
    private $iterables;

    /**
     * Product constructor.
     *
     * @param iterable ...$iterables
     */
    public function __construct(iterable ...$iterables)
    {
        $this->iterables = $iterables;
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): Closure
    {
        $iterables = $this->iterables;

        $cartesian = function (array $input): Generator {
            return $this->cartesian($input);
        };

        return static function () use ($iterables, $collection, $cartesian): Generator {
            $its = [$collection];

            foreach ($iterables as $iterable) {
                $its[] = new IterableIterator($iterable);
            }

            yield from $cartesian($its);
        };
    }

    /**
     * @param array<iterable> $iterators
     *
     * @return Generator<array>
     */
    private function cartesian(array $iterators): Generator
    {
        $iterator = array_pop($iterators);

        if (null === $iterator) {
            return yield [];
        }

        foreach ($this->cartesian($iterators) as $item) {
            foreach ($iterator as $value) {
                yield $item + [count($item) => $value];
            }
        }
    }
}
