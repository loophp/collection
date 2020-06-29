<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Transformation;

use loophp\collection\Contract\Transformation;

interface Transformable
{
    /**
     * @param \loophp\collection\Contract\Transformation ...$transformers
     *
     * @return \loophp\collection\Iterator\ClosureIterator|mixed
     */
    public function transform(Transformation ...$transformers);
}
