<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use loophp\collection\Contract\Transformation;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @implements Transformation<TKey, T, string>
 */
final class Implode implements Transformation
{
    /**
     * @var string
     */
    private $glue;

    public function __construct(string $glue = '')
    {
        $this->glue = $glue;
    }

    /**
     * @param iterable<TKey, T> $collection
     */
    public function __invoke(iterable $collection): string
    {
        $result = '';

        foreach ($collection as $value) {
            $result .= $value . $this->glue;
        }

        return rtrim($result, $this->glue);
    }
}
