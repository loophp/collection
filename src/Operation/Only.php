<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Operation;

/**
 * Class Only.
 */
final class Only implements Operation
{
    /**
     * @var array|mixed[]
     */
    private $keys;

    /**
     * Only constructor.
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
    public function on(iterable $collection)
    {
        [$keys] = $this->keys;

        return static function () use ($keys, $collection): \Generator {
            if ([] === $keys) {
                yield from $collection;
            } else {
                $keys = \array_flip($keys);

                foreach ($collection as $key => $value) {
                    if (true === \array_key_exists($key, $keys)) {
                        yield $key => $value;
                    }
                }
            }
        };
    }
}
