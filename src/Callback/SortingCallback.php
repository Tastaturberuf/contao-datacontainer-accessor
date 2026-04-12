<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor\Callback;

use Closure;

enum SortingCallback: string
{
    case PasteButton = 'paste_button_callback';
    case ChildRecord = 'child_record_callback';

    case Header = 'header_callback';
    case Panel = 'panel_callback';

    /**
     * @mago-expect analysis:mixed-array-assignment
     * @mago-expect lint:no-global
     */
    public function create(string $table, Closure $callback): void
    {
        $GLOBALS['TL_DCA'][$table]['list']['sorting'][$this->value] = $callback;
    }
}
