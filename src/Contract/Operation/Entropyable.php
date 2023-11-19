<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Entropyable
{
    /**
     * This method extends the library's functionality by allowing users to calculate
     * the normalized Shannon entropy of each item in a collection. Since it is not
     * possible to calculate it lazily just like in the `average` operation, this
     * operation returns a collection of entropy values, calculated individually for
     * each item. Therefore, if you're looking for the entropy of the whole collection,
     * you must get the last item using `last` operation.
     *
     * The implementation provides the normalized version of Shannon entropy.
     * Normalization ensures that the entropy value is scaled between `0` and `1`,
     * making it easier to compare entropy across different collections, irrespective
     * of their size or the diversity of elements they contain.
     *
     * An entropy of `0` indicates no diversity (all elements are the same), while an
     * entropy of `1` signifies maximum diversity (all elements are different).
     *
     * @see https://en.wikipedia.org/wiki/Entropy_(information_theory)
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#entropy
     *
     * @return Collection<int, int<0,1>|float>
     */
    public function entropy(): Collection;
}
