<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;
use loophp\collection\Iterator\IterableIterator;
use loophp\collection\Transformation\Run;
use MultipleIterator;

/**
 * Class Zip.
 */
final class Zip implements Operation
{
    /**
     * @var iterable[]
     */
    private $iterables;

    /**
     * Zip constructor.
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
    public function __invoke(): Closure
    {
        $iterables = $this->iterables;

        return static function (iterable $collection) use ($iterables): Generator {
            $items = (
                new Run(
                    (new Walk(
                        static function (iterable $iterable): IterableIterator {
                            return new IterableIterator($iterable);
                        }
                    ))
                ))(array_merge([$collection], $iterables));
            $mit = new MultipleIterator(MultipleIterator::MIT_NEED_ANY);

            foreach (new IterableIterator($items) as $iterator) {
                $mit->attachIterator($iterator);
            }

            foreach ($mit as $values) {
                yield $values;
            }
        };
    }
}
