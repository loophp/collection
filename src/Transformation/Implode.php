<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use Iterator;
use loophp\collection\Contract\Transformation;
use loophp\collection\Transformation\AbstractTransformation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements Transformation<TKey, T>
 */
final class Implode extends AbstractTransformation implements Transformation
{
    public function __construct(string $glue = '')
    {
        $this->storage['glue'] = $glue;
    }

    public function __invoke()
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
