<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

/**
 * Class Limit.
 */
final class Limit extends Operation
{
    /**
     * Limit constructor.
     *
     * @param int $limit
     */
    public function __construct(int $limit)
    {
        parent::__construct(...[$limit]);
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): \Closure
    {
        [$limit] = $this->parameters;

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
