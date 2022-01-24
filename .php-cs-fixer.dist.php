<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

$config = require __DIR__ . '/vendor/drupol/php-conventions/config/php73/php_cs_fixer.config.php';

// specific file ignore introduced based on discussion: https://github.com/loophp/collection/pull/209#discussion_r739684664
$config
    ->getFinder()
    ->ignoreDotFiles(false)
    ->notPath('src/Contract/Operation/Allable.php')
    ->name(['.php_cs.dist']);

$rules = $config->getRules();

$rules['return_assignment'] = false;

return $config->setRules($rules);
