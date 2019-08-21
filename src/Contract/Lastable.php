<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

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
