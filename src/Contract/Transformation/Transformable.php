<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Transformation;

use loophp\collection\Contract\Transformation;

/**
 * Interface Transformable.
 */
interface Transformable
{
    /**
     * @param \loophp\collection\Contract\Transformation ...$transformers
     *
     * @return array<mixed>|bool|int|\loophp\collection\Iterator\ClosureIterator|mixed|string
     */
    public function transform(Transformation ...$transformers);
}
