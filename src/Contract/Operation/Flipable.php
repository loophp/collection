<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

interface Flipable
{
    /**
     * Flip keys and items in a collection.
     *
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public function flip(): Base;
}
