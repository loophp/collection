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
 * @extends AbstractOperation<TKey, T, \Generator<TKey, T>>
 * @implements Operation<TKey, T, \Generator<TKey, T>>
 */
final class Cache extends AbstractOperation implements Operation
{
    public function __construct(?CacheItemPoolInterface $cache = null)
    {
        $this->storage['cache'] = $cache ?? new ArrayAdapter();
    }

    /**
     * @return Closure(\Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        $iteratorIndex = 0;

        return static function (Iterator $iterator, CacheItemPoolInterface $cache) use (&$iteratorIndex): Generator {
            for ($index = 0; true; ++$index) {
                $item = $cache->getItem((string) $index);

                if ($item->isHit()) {
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

                $value = $item->get();

                yield $value[0] => $value[1];
            }
        };
    }
}
