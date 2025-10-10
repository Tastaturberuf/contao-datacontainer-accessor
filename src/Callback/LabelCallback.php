<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor\Callback;

enum LabelCallback: string
{

    case Group = 'group_callback';
    case Label = 'label_callback';

}
