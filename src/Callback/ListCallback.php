<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor\Callback;

enum ListCallback: string
{

    case PasteButton = 'paste_button_callback';
    case ChildRecord = 'child_record_callback';

    case Header = 'header_callback';
    case Panel = 'panel_callback';

}
