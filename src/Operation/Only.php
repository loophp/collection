<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;

use function array_key_exists;

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
    public function __invoke(): Closure
    {
        $keys = $this->keys;

        return static function (iterable $collection) use ($keys): Generator {
            if ([] === $keys) {
                return yield from $collection;
            }

            $keys = array_flip($keys);

            foreach ($collection as $key => $value) {
                if (true === array_key_exists($key, $keys)) {
                    yield $key => $value;
                }
            }
        };
    }
}
