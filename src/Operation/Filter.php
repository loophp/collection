<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use CallbackFilterIterator;
use Closure;
use Generator;
use loophp\collection\Contract\Operation;
use loophp\collection\Iterator\IterableIterator;

/**
 * Class Filter.
 */
final class Filter implements Operation
{
    /**
     * @var callable[]
     */
    private $callbacks;

    /**
     * Filter constructor.
     *
     * @param callable ...$callbacks
     */
    public function __construct(callable ...$callbacks)
    {
        $this->callbacks = $callbacks;
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): Closure
    {
        $callbacks = $this->callbacks;

        return static function () use ($callbacks, $collection): Generator {
            $iterator = $collection;

            foreach ($callbacks as $callback) {
                yield from $iterator = new CallbackFilterIterator(new IterableIterator($iterator), $callback);
            }
        };
    }
}
