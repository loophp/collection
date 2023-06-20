<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

/**
 * @template TKey
 * @template T
 */
interface Unlinesable
{
    /**
     * Opposite of `lines`, creates a single string from multiple lines using `PHP_EOL` as the glue.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#unlines
     */
    public function unlines(): string;
}
