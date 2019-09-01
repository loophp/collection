<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Operation;

/**
 * Class Limit.
 */
final class Limit implements Operation
{
    /**
     * @var int
     */
    private $limit;

    /**
     * Limit constructor.
     *
     * @param int $limit
     */
    public function __construct(int $limit)
    {
        $this->limit = $limit;
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): \Closure
    {
        $limit = $this->limit;

        return static function () use ($limit, $collection): \Generator {
            $i = 0;

            foreach ($collection as $key => $value) {
                yield $key => $value;

                if (++$i === $limit) {
                    break;
                }
            }
        };
    }
}
