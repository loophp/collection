<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App;

require_once __DIR__ . '/../../../vendor/autoload.php';

use JsonMachine\JsonMachine;
use loophp\collection\Collection;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\ChunkInterface;

/**
 * In order to get this working, you will need the library halaxa/json-machine.
 * Use composer to install it in your project.
 *
 * composer require halaxa/json-machine
 *
 * halaxa/json-machine is a lazy JSON parser and it is fully compatible
 * with loophp/collection.
 */

// Parse a local JSON file
$composerJson = __DIR__ . '/../../../composer.json';

$json = Collection::fromIterable(JsonMachine::fromFile($composerJson));

foreach ($json as $key => $value) {
}

$remoteFile = 'https://httpbin.org/anything';

// Parse a remote JSON file with Guzzle
$client = new \GuzzleHttp\Client();
$response = $client->request('GET', $remoteFile);
$phpStream = \GuzzleHttp\Psr7\StreamWrapper::getResource($response->getBody());

$json = Collection::fromIterable(\JsonMachine\JsonMachine::fromStream($phpStream));

foreach ($json as $key => $value) {
}

// Parse a remote JSON file with Symfony HTTP client
$client = HttpClient::create();
$response = $client->request('GET', $remoteFile);

$json = Collection::fromIterable(
    JsonMachine::fromIterable(
        Collection::fromIterable($client->stream($response))
            ->map(
                static fn (ChunkInterface $chunk): string => $chunk->getContent()
            )
    )
);

foreach ($json as $key => $value) {
}
