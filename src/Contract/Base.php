<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

use IteratorAggregate;

/**
 * Interface Base.
 *
 * @template-extends IteratorAggregate<mixed>
 */
interface Base extends IteratorAggregate, Runable, Transformable
{
}
