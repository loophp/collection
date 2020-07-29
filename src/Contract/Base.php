<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

use IteratorAggregate;
use loophp\collection\Contract\Transformation\Runable;
use loophp\collection\Contract\Transformation\Transformable;

/**
 * Interface Base.
 *
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 *
 * @template-extends IteratorAggregate<mixed>
 * @template-extends Runable<TKey, T>
 * @template-extends Transformable<TKey, T>
 */
interface Base extends IteratorAggregate, Runable, Transformable
{
}
