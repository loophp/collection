<?php

declare(strict_types=1);

namespace App;

use loophp\collection\Collection;

include __DIR__ . '/../../../../vendor/autoload.php';

// Get data from a file
Collection::fromFile('/etc/passwd');

// Get data from a URL
Collection::fromFile('http://loripsum.net/api');

// Get data from a CSV file
Collection::fromFile('data.csv', fgetcsv(...));
