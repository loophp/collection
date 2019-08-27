<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Iterator\ClosureIterator;

/**
 * Class Zip.
 */
final class Zip extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function on(\Traversable $collection): \Closure
    {
        [$iterables] = $this->parameters;

        return static function () use ($iterables, $collection): \Generator {
            $getIteratorCallback = static function ($iterable) {
                return new ClosureIterator(
                    static function () use ($iterable) {
                        foreach ($iterable as $k => $v) {
                            yield $k => $v;
                        }
                    }
                );
            };

            $items = \array_merge([$collection], $iterables);

            $walk = new Walk($getIteratorCallback);
            $append = new Append($items);

            $iterators = new ClosureIterator(
                $walk->on(new ClosureIterator($append->on(new \ArrayObject())))
            );

            $mit = new \MultipleIterator(\MultipleIterator::MIT_NEED_ANY);

            foreach ($iterators as $iterator) {
                $mit->attachIterator($iterator);
            }

            foreach ($mit as $values) {
                yield new \ArrayObject($values);
            }
        };
    }
}
