<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor;

/**
 * @see https://docs.contao.org/dev/reference/dca/list/#sorting
 */
final class Sorting
{

    public int $mode {
        get => $GLOBALS['TL_DCA'][$this->table]['config']['sorting']['mode'] ?? 0;
        set {
            $GLOBALS['TL_DCA'][$this->table]['config']['sorting']['mode'] = $value;
        }
    }

    public int $flag {
        get => $GLOBALS['TL_DCA'][$this->table]['config']['sorting']['flag'] ?? 0;
        set {
            $GLOBALS['TL_DCA'][$this->table]['config']['sorting']['flag'] = $value;
        }
    }

    public ?string $panelLayout {
        get => $GLOBALS['TL_DCA'][$this->table]['config']['sorting']['panelLayout'] ?? null;
        set {
            $GLOBALS['TL_DCA'][$this->table]['config']['sorting']['panelLayout'] = $value;
        }
    }

    public array $fields {
        get => $GLOBALS['TL_DCA'][$this->table]['config']['sorting']['fields'] ?? [];
        set {
            $GLOBALS['TL_DCA'][$this->table]['config']['sorting']['fields'] = $value;
        }
    }

    public array $headerFields {
        get => $GLOBALS['TL_DCA'][$this->table]['config']['sorting']['headerFields'] ?? [];
        set {
            $GLOBALS['TL_DCA'][$this->table]['config']['sorting']['headerFields'] = $value;
        }
    }

    public ?string $icon {
        get => $GLOBALS['TL_DCA'][$this->table]['config']['sorting']['icon'] ?? null;
        set {
            $GLOBALS['TL_DCA'][$this->table]['config']['sorting']['icon'] = $value;
        }
    }

    public array $rootElements {
        get => $GLOBALS['TL_DCA'][$this->table]['config']['sorting']['rootElements'] ?? [];
        set {
            $GLOBALS['TL_DCA'][$this->table]['config']['sorting']['rootElements'] = $value;
        }
    }

    public bool $rootPaste {
        get => $GLOBALS['TL_DCA'][$this->table]['config']['sorting']['rootPaste'] ?? false;
        set {
            $GLOBALS['TL_DCA'][$this->table]['config']['sorting']['rootPaste'] = $value;
        }
    }

    //@todo test sub arrays
    public array $filter {
        get => $GLOBALS['TL_DCA'][$this->table]['config']['sorting']['filter'] ?? [];
        set {
            $GLOBALS['TL_DCA'][$this->table]['config']['sorting']['filter'] = $value;
        }
    }

    public bool $disableGrouping {
        get => $GLOBALS['TL_DCA'][$this->table]['config']['sorting']['disableGrouping'] ?? false;
        set {
            $GLOBALS['TL_DCA'][$this->table]['config']['sorting']['disableGrouping'] = $value;
        }
    }

    public ?string $defaultSearchField {
        get => $GLOBALS['TL_DCA'][$this->table]['config']['sorting']['defaultSearchField'] ?? null;
        set {
            $GLOBALS['TL_DCA'][$this->table]['config']['sorting']['defaultSearchField'] = $value;
        }
    }


    /**
     * These functions will be called instead of displaying the default paste buttons.
     * @todo test array is a callable
     */
    public null|\Closure|array $paste_button_callback {
        get => $GLOBALS['TL_DCA'][$this->table]['config']['sorting']['paste_button_callback'] ?? null;
        set {
            if (is_callable($value) || null === $value) {
                $GLOBALS['TL_DCA'][$this->table]['config']['sorting']['paste_button_callback'] = $value;
            }

            throw new \InvalidArgumentException('The paste_button_callback must be a callable or null.');
        }

    }

    /**
     * These functions must be specified to render the child elements (sorting mode 4 only).
     */
    public null|\Closure|array $child_record_callback {
        get => $GLOBALS['TL_DCA'][$this->table]['config']['sorting']['child_record_callback'] ?? null;
        set {
            if (is_callable($value) || null === $value) {
                $GLOBALS['TL_DCA'][$this->table]['config']['sorting']['child_record_callback'] = $value;
            }

            throw new \InvalidArgumentException('The child_record_callback must be a callable or null.');
        }
    }

    public null|\Closure|array $header_callback {
        get => $GLOBALS['TL_DCA'][$this->table]['config']['sorting']['header_callback'] ?? null;
        set {
            if (is_callable($value) || null === $value) {
                $GLOBALS['TL_DCA'][$this->table]['config']['sorting']['header_callback'] = $value;
            }

            throw new \InvalidArgumentException('The header_callback must be a callable or null.');
        }
    }

    public null|\Closure|array $panel_callback {
        get => $GLOBALS['TL_DCA'][$this->table]['config']['sorting']['panel_callback'] ?? null;
        set {
            if (is_callable($value) || null === $value) {
                $GLOBALS['TL_DCA'][$this->table]['config']['sorting']['panel_callback'] = $value;
            }

            throw new \InvalidArgumentException('The panel_callback must be a callable or null.');
        }
    }

    public string $child_record_class {
        get => $GLOBALS['TL_DCA'][$this->table]['config']['sorting']['child_record_class'] ?? '';
        set => $GLOBALS['TL_DCA'][$this->table]['config']['sorting']['child_record_class'] = $value;
    }

    public function __construct(private readonly string $table)
    {
    }

}
