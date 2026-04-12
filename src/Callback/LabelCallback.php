<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor\Callback;

use Closure;

enum LabelCallback: string
{
    case Group = 'group_callback';
    case Label = 'label_callback';

    /**
     * @mago-expect analysis:mixed-array-assignment
     * @mago-expect lint:no-global
     */
    public function create(string $table, Closure $callback): void
    {
        $GLOBALS['TL_DCA'][$table]['list']['label'][$this->value] = $callback;
    }
}
