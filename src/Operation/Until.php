<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;

final class Until extends AbstractOperation implements Operation
{
    public function __construct(callable ...$callbacks)
    {
        $this->storage['callbacks'] = $callbacks;
    }

    public function __invoke(): Closure
    {
        return static function (iterable $collection, array $callbacks): Generator {
            foreach ($collection as $key => $value) {
                yield $key => $value;

                $result = 1;

                foreach ($callbacks as $callback) {
                    $result &= $callback($value, $key);
                }

                if (1 === $result) {
                    break;
                }
            }
        };
    }
}
