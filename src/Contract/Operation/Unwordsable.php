<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

/**
 * @template TKey
 * @template T
 */
interface Unwordsable
{
    /**
     * Opposite of `words` and similar to `unlines`, creates a single string
     * from multiple strings using one space as the glue.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#unwords
     */
    public function unwords(): string;
}
