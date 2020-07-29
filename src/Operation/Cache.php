<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 */
final class Cache extends AbstractOperation implements Operation
{
    public function __construct(?CacheItemPoolInterface $cache = null)
    {
        $this->storage['cache'] = $cache ?? new ArrayAdapter();
    }

    public function __invoke(): Closure
    {
        $iteratorIndex = 0;

        return
            /**
             * @psalm-param \Iterator<TKey, T> $iterator
             *
             * @psalm-return \Generator<TKey, T>
             */
            static function (Iterator $iterator, CacheItemPoolInterface $cache) use (&$iteratorIndex): Generator {
                for ($index = 0; true; ++$index) {
                    $item = $cache->getItem((string) $index);

                    if ($item->isHit()) {
                        /** @psalm-var array{TKey, T} $value */
                        $value = $item->get();

                        yield $value[0] => $value[1];

                        continue;
                    }

                    if ($iteratorIndex < $index) {
                        $iterator->next();

                        ++$iteratorIndex;
                    }

                    if (!$iterator->valid()) {
                        break;
                    }

                    $item->set([
                        $iterator->key(),
                        $iterator->current(),
                    ]);

                    $cache->save($item);

                    /** @psalm-var array{TKey, T} $value */
                    $value = $item->get();

                    yield $value[0] => $value[1];
                }
            };
    }
}
