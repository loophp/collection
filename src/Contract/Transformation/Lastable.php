<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Transformation;

interface Lastable
{
    /**
     * Get the last item.
     *
     * @return mixed
     */
    public function last();
}
