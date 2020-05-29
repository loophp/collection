<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Collection;
use loophp\collection\Contract\Operation;
use loophp\collection\Iterator\ClosureIterator;
use loophp\collection\Iterator\IterableIterator;

/**
 * Class Window.
 */
final class Window implements Operation
{
    /**
     * @var array<int, int>
     */
    private $length;

    /**
     * Window constructor.
     *
     * @param array<int, int> $length
     */
    public function __construct(int ...$length)
    {
        $this->length = $length;
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): Closure
    {
        $length = $this->length;

        return static function () use ($length, $collection): Generator {
            $i = 0;

            $length = new IterableIterator((new Collection($length))->loop());

            // Todo: Find a way to get rid of unused variable $value.
            foreach ($collection as $value) {
                yield iterator_to_array(new ClosureIterator((new Slice($i++, $length->current()))->on($collection)));
                $length->next();
            }
        };
    }
}
