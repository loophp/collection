<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;

final class Skip extends AbstractOperation implements Operation
{
    public function __construct(int ...$skip)
    {
        $this->storage['skip'] = $skip;
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @param array<int, int> $skip
             * @param iterable $collection
             */
            static function (iterable $collection, array $skip): Generator {
                $skip = array_sum($skip);

                foreach ($collection as $key => $value) {
                    if (0 < $skip--) {
                        continue;
                    }

                    yield $key => $value;
                }
            };
    }
}
