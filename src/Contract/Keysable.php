<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * Interface Keysable.
 */
interface Keysable
{
    /**
     * Get the keys of the items.
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function keys(): Base;
}
