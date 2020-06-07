<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\Run;

/**
 * Class Column.
 */
final class Column implements Operation
{
    /**
     * @var int|string
     */
    private $column;

    /**
     * Column constructor.
     *
     * @param int|string $column
     */
    public function __construct($column)
    {
        $this->column = $column;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(): Closure
    {
        $column = $this->column;

        return static function (iterable $collection) use ($column): Generator {
            foreach ((new Run((new Transpose())))($collection) as $key => $value) {
                if ($key === $column) {
                    return yield from $value;
                }
            }
        };
    }
}
