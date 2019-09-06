<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Transformable.
 */
interface Transformable
{
    /**
     * @param \drupol\collection\Contract\Transformer ...$transformers
     *
     * @return bool|int|mixed|string
     */
    public function transform(Transformer ...$transformers);
}
