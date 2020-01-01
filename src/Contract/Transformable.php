<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * Interface Transformable.
 */
interface Transformable
{
    /**
     * @param \loophp\collection\Contract\Transformation ...$transformers
     *
     * @return bool|int|mixed|string
     */
    public function transform(Transformation ...$transformers);
}
