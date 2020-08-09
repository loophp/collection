<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Iterator;
use loophp\collection\Contract\Operation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements Operation<TKey, T>
 */
final class Implode extends AbstractGeneratorOperation implements Operation
{
    public function __construct(string $glue = '')
    {
        $this->storage['glue'] = $glue;
    }

    public function __invoke(): Closure
    {
        return static function (Iterator $collection, string $glue): string {
            $result = '';

            foreach ($collection as $value) {
                $result .= $value . $glue;
            }

            return rtrim($result, $glue);
        };
    }
}
