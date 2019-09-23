<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Transformable.
 */
interface Transformable
{
    /**
     * @param \drupol\collection\Contract\Transformation ...$transformers
     *
     * @return bool|int|mixed|string
     */
    public function transform(Transformation ...$transformers);
}
