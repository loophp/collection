<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

use IteratorAggregate;

/**
 * Interface Base.
 */
interface Base extends IteratorAggregate, Runable, Transformable
{
}
