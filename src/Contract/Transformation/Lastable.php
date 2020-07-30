<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Transformation;

/**
 * @template T
 */
interface Lastable
{
    /**
     * Get the last item.
     *
     * @return mixed
     * @psalm-return T
     */
    public function last();
}
