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
    public function __invoke(): Closure
    {
        $callbacks = $this->callbacks;

        return static function (iterable $collection) use ($callbacks): Generator {
            $iterator = new IterableIterator($collection);

            foreach ($callbacks as $callback) {
                $iterator = new CallbackFilterIterator($iterator, $callback);
            }

            yield from $iterator;
        };
    }
}
