<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;

/**
 * Class Keys.
 */
final class Keys implements Operation
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(): Closure
    {
        return static function (iterable $collection): Generator {
            foreach ($collection as $key => $value) {
                yield $key;
            }
        };
    }
}
