<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Transformation;

use loophp\collection\Contract\Operation;

interface Runable
{
    /**
     * @param \loophp\collection\Contract\Operation ...$operations
     *
     * @return \loophp\collection\Base|\loophp\collection\Collection
     */
    public function run(Operation ...$operations);
}
