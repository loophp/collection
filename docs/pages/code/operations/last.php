<?php

declare(strict_types=1);

namespace App;

use loophp\collection\Collection;

include __DIR__ . '/../../../../vendor/autoload.php';

Collection::fromIterable(['a', 'b', 'c'])
    ->last(); // 'c'

Collection::fromIterable(['a', 'b', 'c'])
    ->last('default_value'); // 'c'

Collection::empty()
    ->last('default_value'); // 'default_value'
