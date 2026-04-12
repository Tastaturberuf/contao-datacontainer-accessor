<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor\Callback;

use Closure;

enum FieldCallback: string
{
    case Options = 'options_callback';
    case InputField = 'input_field_callback';

    case Wizard = 'wizard';

    case Load = 'load_callback';

    case Save = 'save_callback';

    case XLabel = 'xlabel';

    case Attributes = 'attributes_callback';

    /**
     * @mago-expect analysis:mixed-array-assignment
     * @mago-expect lint:no-global
     */
    public function create(string $table, string $field, Closure $callback): void
    {
        match ($this->value) {
            self::Options->value,
            self::InputField->value,
                => $GLOBALS['TL_DCA'][$table]['fields'][$field][$this->value] = $callback,
            default => $GLOBALS['TL_DCA'][$table]['fields'][$field][$this->value][] = $callback,
        };
    }
}
