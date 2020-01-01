<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * Interface Lastable.
 */
interface Lastable
{
    /**
     * Get the last item.
     *
     * @return mixed
     */
    public function last();
}
