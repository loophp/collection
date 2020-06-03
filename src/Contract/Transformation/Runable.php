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
     * @return \loophp\collection\Base<mixed>|\loophp\collection\Collection<mixed>
     */
    public function run(Operation ...$operations);
}
