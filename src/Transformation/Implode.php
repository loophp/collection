<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use Iterator;
use loophp\collection\Contract\Transformation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements Transformation<TKey, T>
 */
final class Implode implements Transformation
{
    /**
     * @var string
     */
    private $glue;

    public function __construct(string $glue)
    {
        $this->glue = $glue;
    }

    public function __invoke(Iterator $collection): string
    {
        $result = '';

        foreach ($collection as $value) {
            $result .= $value . $this->glue;
        }

        return rtrim($result, $this->glue);
    }
}
