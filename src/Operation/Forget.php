<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Operation;

/**
 * Class Forget.
 */
final class Forget implements Operation
{
    /**
     * @var array|mixed[]
     */
    private $keys;

    /**
     * Forget constructor.
     *
     * @param mixed ...$keys
     */
    public function __construct(...$keys)
    {
        $this->keys = $keys;
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): \Closure
    {
        [$keys] = $this->keys;

        return static function () use ($keys, $collection): \Generator {
            $keys = \array_flip($keys);

            foreach ($collection as $key => $value) {
                if (false === \array_key_exists($key, $keys)) {
                    yield $key => $value;
                }
            }
        };
    }
}
