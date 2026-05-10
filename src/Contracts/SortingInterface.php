<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor\Contracts;

use Closure;

/**
 * @api
 *
 * @see https://docs.contao.org/dev/reference/dca/list/#sorting
 */
interface SortingInterface
{
    public ?int $mode { get; set; }

    public ?int $flag { get; set; }

    public ?string $panelLayout { get; set; }

    public ?array $fields { get; set; }

    public ?array $headerFields { get; set; }

    public ?string $icon { get; set; }

    public ?array $rootElements { get; set; }

    public ?bool $rootPaste { get; set; }

    public ?array $filter { get; set; }

    public ?bool $disableGrouping { get; set; }

    public ?string $defaultSearchField { get; set; }

    public ?string $childRecordClass { get; set; }

    public null|array|Closure $pasteButtonCallback { get; set; }

    public null|array|Closure $childRecordCallback { get; set; }

    public null|array|Closure $headerCallback { get; set; }

    public null|array|Closure $panelRecordCallback { get; set; }

    public function __invoke(Closure $callback): void;
}
