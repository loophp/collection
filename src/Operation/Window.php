<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;
use loophp\collection\Iterator\IterableIterator;
use loophp\collection\Transformation\Run;

final class Window extends AbstractOperation implements Operation
{
    public function __construct(int ...$length)
    {
        $this->storage['length'] = $length;
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @param array<int, int> $length
             */
            static function (iterable $collection, array $length): Generator {
                $i = 0;

                $length = new IterableIterator((new Run(new Loop()))($length));

                // Todo: Find a way to get rid of unused variable $value.
                foreach ($collection as $value) {
                    yield iterator_to_array((new Run(new Slice($i++, $length->current())))($collection));
                    $length->next();
                }
            };
    }
}
