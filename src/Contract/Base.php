<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

use IteratorAggregate;
use loophp\collection\Contract\Transformation\Runable;
use loophp\collection\Contract\Transformation\Transformable;

/**
 * Interface Base.
 *
 * @template-extends IteratorAggregate<mixed>
 */
interface Base extends IteratorAggregate, Runable, Transformable
{
}
