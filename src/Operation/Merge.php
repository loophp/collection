<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use Closure;
use drupol\collection\Contract\Operation;
use Generator;

/**
 * Class Merge.
 */
final class Merge implements Operation
{
    /**
     * @var iterable[]
     */
    private $sources;

    /**
     * Merge constructor.
     *
     * @param iterable ...$sources
     */
    public function __construct(iterable ...$sources)
    {
        $this->sources = $sources;
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): Closure
    {
        [$sources] = $this->sources;

        return static function () use ($sources, $collection): Generator {
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
