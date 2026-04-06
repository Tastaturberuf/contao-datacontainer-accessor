<?php

declare(strict_types=1);

use Tastaturberuf\ContaoDataContainerAccessor\Config;

require __DIR__ . '/../vendor/autoload.php';

$runs = isset($argv[1]) ? max(1, (int) $argv[1]) : 10;
$iterations = isset($argv[2]) ? max(1, (int) $argv[2]) : 1000;

$direct = [];
$configSet = [];
$config = Config::create('tl_example');

for ($r = 0; $r < $runs; ++$r) {
    $GLOBALS['TL_DCA']['tl_example']['config']['test'] = null;

    $start = hrtime(true);
    for ($i = 0; $i < $iterations; ++$i) {
        $GLOBALS['TL_DCA']['tl_example']['config']['test'] = $i;
    }
    $direct[] = hrtime(true) - $start;
    $directValue = $GLOBALS['TL_DCA']['tl_example']['config']['test'] ?? null;

    // cut

    $GLOBALS['TL_DCA']['tl_example']['config']['test'] = null;

    $start = hrtime(true);
    for ($i = 0; $i < $iterations; ++$i) {
        $config->set('test', $i);
    }
    $configSet[] = hrtime(true) - $start;
    $configValue = $config->get('test') ?? null;
}

sort($direct);
sort($configSet);

$mid = intdiv($runs, 2);
$directMedian = ($runs % 2) === 0 ? intdiv($direct[$mid - 1] + $direct[$mid], 2) : $direct[$mid];
$configMedian = ($runs % 2) === 0 ? intdiv($configSet[$mid - 1] + $configSet[$mid], 2) : $configSet[$mid];

printf("runs=%d iterations=%d\n", $runs, $iterations);
printf("direct_set_median_ns=%d direct_set_median_ms=%.6f\n", $directMedian, $directMedian / 1e6);
printf("config_set_median_ns=%d config_set_median_ms=%.6f\n", $configMedian, $configMedian / 1e6);
printf("ratio_config_vs_direct=%.2f\n", $configMedian / max(1, $directMedian));
printf("last_values=%s/%s\n", (string) $directValue, (string) $configValue);
