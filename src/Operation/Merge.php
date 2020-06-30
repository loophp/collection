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
             * @param iterable $collection
             */
            static function (iterable $collection, array $sources): Generator {
                foreach ($collection as $value) {
                    yield $value;
                }

                foreach ($sources as $source) {
                    foreach ($source as $value) {
                        yield $value;
                    }
                }
            };
    }
}
