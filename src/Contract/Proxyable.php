<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Proxyable.
 */
interface Proxyable
{
    /**
     * @param string $method
     * @param \Closure|string $proxyMethod
     * @param mixed ...$parameters
     *
     * @return \drupol\collection\Contract\BaseCollection
     */
    public function proxy(string $method, $proxyMethod, ...$parameters): BaseCollection;
}
