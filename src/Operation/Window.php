<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
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
            static function (Iterator $iterator, array $length): Generator {
                $length = new IterableIterator((new Run(new Loop()))($length));

                for ($i = 0; iterator_count($iterator) > $i; ++$i) {
                    yield iterator_to_array((new Run(new Slice($i, $length->current())))($iterator));
                    $length->next();
                }
            };
    }
}
