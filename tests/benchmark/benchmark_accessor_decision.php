<?php

declare(strict_types=1);

use Tastaturberuf\ContaoDataContainerAccessor\Config;
use Tastaturberuf\ContaoDataContainerAccessor\DcaPathAccessor;


require __DIR__ . '/../../vendor/autoload.php';

$runs = isset($argv[1]) ? max(1, (int) $argv[1]) : 10;
$iterations = isset($argv[2]) ? max(1, (int) $argv[2]) : 1000;
$mode = $argv[3] ?? 'setget'; // set | setget

if ($mode !== 'set' && $mode !== 'setget') {
    fwrite(STDERR, "Invalid mode. Use 'set' or 'setget'.\n");
    exit(1);
}

$path = ['tl_example', 'config', 'test'];
$config = Config::create('tl_example');

$direct = [];
$configApi = [];
$accessor = [];

$labels = ['direct', 'config', 'accessor'];

for ($r = 0; $r < $runs; ++$r) {
    $order = $labels;
    shuffle($order);

    foreach ($order as $label) {
        unset($GLOBALS['TL_DCA']);
        $start = hrtime(true);

        if ($label === 'direct') {
            if ($mode === 'set') {
                for ($i = 0; $i < $iterations; ++$i) {
                    $GLOBALS['TL_DCA']['tl_example']['config']['test'] = $i;
                }
            } else {
                for ($i = 0; $i < $iterations; ++$i) {
                    $GLOBALS['TL_DCA']['tl_example']['config']['test'] = $i;
                    $directValue = $GLOBALS['TL_DCA']['tl_example']['config']['test'];
                }
            }

            $direct[] = hrtime(true) - $start;
            continue;
        }

        if ($label === 'config') {
            if ($mode === 'set') {
                for ($i = 0; $i < $iterations; ++$i) {
                    $config->test = $i;
                }
            } else {
                for ($i = 0; $i < $iterations; ++$i) {
                    $config->test = $i;
                    $configValue = $config->test;
                }
            }

            $configApi[] = hrtime(true) - $start;
            continue;
        }

        if ($mode === 'set') {
            for ($i = 0; $i < $iterations; ++$i) {
                DcaPathAccessor::set($i, 'tl_example', 'config', 'test');
            }
        } else {
            for ($i = 0; $i < $iterations; ++$i) {
                DcaPathAccessor::set($i, 'tl_example', 'config', 'test');
                $accessorValue = DcaPathAccessor::get('tl_example', 'config', 'test');
            }
        }

        $accessor[] = hrtime(true) - $start;
    }
}

sort($direct);
sort($configApi);
sort($accessor);

$mid = intdiv($runs, 2);
$median = static function (array $values) use ($runs, $mid): int {
    if (($runs % 2) === 0) {
        return intdiv($values[$mid - 1] + $values[$mid], 2);
    }

    return $values[$mid];
};

$directMedian = $median($direct);
$configMedian = $median($configApi);
$accessorMedian = $median($accessor);

printf("runs=%d iterations=%d mode=%s\n", $runs, $iterations, $mode);
printf("path=%s\n", implode('.', $path));
printf("direct_median_ns=%d direct_median_ms=%.6f\n", $directMedian, $directMedian / 1e6);
printf("config_median_ns=%d config_median_ms=%.6f\n", $configMedian, $configMedian / 1e6);
printf("accessor_median_ns=%d accessor_median_ms=%.6f\n", $accessorMedian, $accessorMedian / 1e6);
printf("ratio_config_vs_direct=%.2f\n", $configMedian / max(1, $directMedian));
printf("ratio_accessor_vs_direct=%.2f\n", $accessorMedian / max(1, $directMedian));
printf(
    "overhead_ns_per_call config=%.2f accessor=%.2f\n",
    ($configMedian - $directMedian) / max(1, $iterations),
    ($accessorMedian - $directMedian) / max(1, $iterations),
);
if ($mode === 'setget') {
    printf("last_values=%s/%s/%s\n", (string) $directValue, (string) $configValue, (string) $accessorValue);
}
