<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\Run;

final class Column extends AbstractOperation implements Operation
{
    /**
     * Column constructor.
     *
     * @param int|string $column
     */
    public function __construct($column)
    {
        $this->storage['column'] = $column;
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @param int|string $column
             * @param iterable $collection
             */
            static function (iterable $collection, $column): Generator {
                foreach ((new Run((new Transpose())))($collection) as $key => $value) {
                    if ($key === $column) {
                        return yield from $value;
                    }
                }
            };
    }
}
