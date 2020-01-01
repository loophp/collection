<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;

/**
 * Class Collapse.
 */
final class Collapse implements Operation
{
    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): Closure
    {
        return static function () use ($collection): Generator {
            foreach ($collection as $value) {
                if (true !== is_iterable($value)) {
                    continue;
                }

                foreach ($value as $subValue) {
                    yield $subValue;
                }
            }
        };
    }
}
