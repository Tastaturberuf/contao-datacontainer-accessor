<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor\Contracts;

use Closure;

/**
 * @api
 *
 * @see https://docs.contao.org/dev/reference/dca/list/#labels
 */
interface LabelInterface
{
    /**
     * One or more fields that will be shown in the list (e.g. ['title', 'user_id:tl_user.name']).
     */
    public ?array $fields { get; set; }

    /**
     * If true, Contao will generate a table header with column names (e.g. back end member list)
     */
    public ?bool $showColumns { get; set; }

    /**
     * If false, Contao will not force the first sorting field to show up in the list. (default: true)
     */
    public ?bool $showFirstOrderBy { get; set; }

    /**
     * HTML string used to format the fields that will be shown (e.g. `%s (%s)`).
     */
    public ?string $format { get; set; }

    /**
     * The maximum number of characters to show in the list. (default: null)
     */
    public ?int $maxCharacters { get; set; }

    public null|array|Closure $groupCallback { get; set; }

    public null|array|Closure $labelCallback { get; set; }
}
