<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor\Callback;

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

}

