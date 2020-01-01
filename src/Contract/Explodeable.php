<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * Interface Explodeable.
 */
interface Explodeable
{
    /**
     * @param string ...$explodes
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function explode(string ...$explodes): Base;
}
