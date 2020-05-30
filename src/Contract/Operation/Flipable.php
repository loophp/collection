<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

/**
 * Interface Flipable.
 */
interface Flipable
{
    /**
     * Flip keys and items in a collection.
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function flip(): Base;
}
