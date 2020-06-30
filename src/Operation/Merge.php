<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;

final class Merge extends AbstractOperation implements Operation
{
    /**
     * Merge constructor.
     *
     * @param iterable<mixed> ...$sources
     */
    public function __construct(iterable ...$sources)
    {
        $this->storage['sources'] = $sources;
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @param array<int, iterable> $sources
             */
            static function (iterable $collection, array $sources): Generator {
                foreach ($collection as $key => $value) {
                    yield $key => $value;
                }

                foreach ($sources as $source) {
                    foreach ($source as $key => $value) {
                        yield $key => $value;
                    }
                }
            };
    }
}
