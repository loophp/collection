<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Transformation;

use loophp\collection\Contract\Operation;

/**
 * Interface Runable.
 */
interface Runable
{
    /**
     * @param \loophp\collection\Contract\Operation ...$operations
     *
     * @return bool|int|\loophp\collection\Contract\Base|\loophp\collection\Contract\Collection|mixed
     */
    public function run(Operation ...$operations);
}
