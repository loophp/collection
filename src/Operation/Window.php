<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Collection;
use loophp\collection\Contract\Operation;
use loophp\collection\Iterator\IterableIterator;
use loophp\collection\Transformation\Run;

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
    public function __invoke(): Closure
    {
        $length = $this->length;

        return static function (iterable $collection) use ($length): Generator {
            $i = 0;

            $length = new IterableIterator((new Collection($length))->loop());

            // Todo: Find a way to get rid of unused variable $value.
            foreach ($collection as $value) {
                $slice = new Slice($i++, $length->current());

                yield iterator_to_array((new Run($slice))($collection));

                $length->next();
            }
        };
    }
}
