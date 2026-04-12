<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor\Callback;

use Closure;

enum ConfigCallback: string
{
    case Load = 'onload_callback';
    case Create = 'oncreate_callback';
    case BeforeSubmit = 'onbeforesubmit_callback';
    case Submit = 'onsubmit_callback';
    case Delete = 'ondelete_callback';
    case Cut = 'oncut_callback';
    case Copy = 'oncopy_callback';
    case CreateVersion = 'onversion_callback';
    case RestoreVersion = 'onrestore_callback';
    case Undo = 'onundo_callback';
    case InvalidateCacheTags = 'oninvalidatecache_tags_callback';
    case Show = 'onshow_callback';
    case Palette = 'onpalette_callback';

    /**
     * @mago-expect analysis:mixed-array-assignment
     * @mago-expect lint:no-global
     */
    public function create(string $table, Closure $callback): void
    {
        $GLOBALS['TL_DCA'][$table]['config'][$this->value][] = $callback;
    }
}
