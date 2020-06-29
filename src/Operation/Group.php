<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;

use function array_key_exists;

final class Group extends AbstractOperation implements Operation
{
    public function __construct(?callable $callable = null)
    {
        $this->storage['callable'] = $callable ??
            /**
             * @param mixed $key
             * @param mixed $value
             *
             * @return mixed
             */
            static function ($key, $value) {
                return $key;
            };
    }

    public function __invoke(): Closure
    {
        return static function (iterable $collection, callable $callable): Generator {
            $data = [];

            foreach ($collection as $key => $value) {
                $key = ($callable)($key, $value);

                if (false === array_key_exists($key, $data)) {
                    $data[$key] = $value;

                    continue;
                }

                $data[$key] = (array) $data[$key];
                $data[$key][] = $value;
            }

            return yield from $data;
        };
    }
}
