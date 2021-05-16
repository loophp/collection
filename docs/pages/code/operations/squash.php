<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App;

use Exception;
use loophp\collection\Collection;

include __DIR__ . '/../../../../vendor/autoload.php';

$results = Collection::fromIterable(range(0, 100))
    ->filter(static fn (int $int) => 0 === $int % 2)
    ->map(static fn (int $int) => 'document' . $int . '.pdf')
    ->map(
        static function (string $doc): bool {
            if (false === file_exists('/doc/' . $doc)) {
                throw new Exception('Unexistent file');
            }

            return file_get_contents($doc);
        }
    )
    ->squash(); // Instantly trigger an exception if a file does not exist.

// If no exception, you can continue the processing...
$results = $results
    ->filter(
        static function (string $document): bool {
            return false !== strpos($document, 'foobar');
        }
    );
