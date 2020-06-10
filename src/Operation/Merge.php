<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;

/**
 * Class Merge.
 */
final class Merge implements Operation
{
    /**
     * @var array<int, iterable<mixed>>
     */
    private $sources;

    /**
     * Merge constructor.
     *
     * @param iterable<mixed> ...$sources
     */
    public function __construct(iterable ...$sources)
    {
        $this->sources = $sources;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(): Closure
    {
        $sources = $this->sources;

        return static function (iterable $collection) use ($sources): Generator {
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
