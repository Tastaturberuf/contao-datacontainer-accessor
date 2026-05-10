<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor;

use Closure;
use Override;
use Tastaturberuf\ContaoDataContainerAccessor\Callback\SortingCallback;
use Tastaturberuf\ContaoDataContainerAccessor\Contracts\SortingInterface;

/**
 * @see https://docs.contao.org/dev/reference/dca/list/#sorting
 *
 * @mago-expect analysis:mixed-return-statement
 * @mago-expect analysis:incompatible-property-access
 * @mago-expect analysis:incompatible-readonly-modifier
 */
final class Sorting extends AbstractAccessor implements SortingInterface
{
    public readonly string $_table;
    public readonly array $_path;
    protected array $_ref;

    public ?int $mode {
        get => $this->_ref['mode'] ?? null;
        set {
            $this->_ref['mode'] = $value;
        }
    }

    public function mode(int $mode): self
    {
        $this->mode = $mode;

        return $this;
    }

    public ?int $flag {
        get => $this->_ref['flag'] ?? null;
        set {
            $this->_ref['flag'] = $value;
        }
    }

    public function flag(int $flag): self
    {
        $this->flag = $flag;

        return $this;
    }

    public ?string $panelLayout {
        get => $this->_ref['panelLayout'] ?? null;
        set {
            $this->_ref['panelLayout'] = $value;
        }
    }

    public function panelLayout(string $panelLayout): self
    {
        $this->panelLayout = $panelLayout;

        return $this;
    }

    public ?array $fields {
        get => $this->_ref['fields'] ?? null;
        set {
            $this->_ref['fields'] = $value;
        }
    }

    public function fields(string ...$fields): self
    {
        $this->fields = $fields;

        return $this;
    }

    public ?array $headerFields {
        get => $this->_ref['headerFields'] ?? null;
        set {
            $this->_ref['headerFields'] = $value;
        }
    }

    public function headerFields(array $headerFields): self
    {
        $this->headerFields = $headerFields;

        return $this;
    }

    public ?string $icon {
        get => $this->_ref['icon'] ?? null;
        set {
            $this->_ref['icon'] = $value;
        }
    }

    public function icon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public ?array $rootElements {
        get => $this->_ref['rootElements'] ?? null;
        set {
            $this->_ref['rootElements'] = $value;
        }
    }

    public function rootElements(array $rootElements): self
    {
        $this->rootElements = $rootElements;

        return $this;
    }

    public ?bool $rootPaste {
        get => $this->_ref['rootPaste'] ?? null;
        set {
            $this->_ref['rootPaste'] = $value;
        }
    }

    public function rootPaste(bool $rootPaste = true): self
    {
        $this->rootPaste = $rootPaste;

        return $this;
    }

    //@todo test sub arrays
    public ?array $filter {
        get => $this->_ref['filter'] ?? null;
        set {
            $this->_ref['filter'] = $value;
        }
    }

    public function filter(array $filter): self
    {
        $this->filter = $filter;

        return $this;
    }

    public ?bool $disableGrouping {
        get => $this->_ref['disableGrouping'] ?? null;
        set {
            $this->_ref['disableGrouping'] = $value;
        }
    }

    public function disableGrouping(bool $disableGrouping = true): self
    {
        $this->disableGrouping = $disableGrouping;

        return $this;
    }

    public ?string $defaultSearchField {
        get => $this->_ref['defaultSearchField'] ?? null;
        set {
            $this->_ref['defaultSearchField'] = $value;
        }
    }

    public function defaultSearchField(string $defaultSearchField): self
    {
        $this->defaultSearchField = $defaultSearchField;

        return $this;
    }

    public ?string $childRecordClass {
        get => $this->_ref['child_record_class'] ?? null;
        set {
            $this->_ref['child_record_class'] = $value;
        }
    }

    public function childRecordClass(string $childRecordClass): self
    {
        $this->childRecordClass = $childRecordClass;

        return $this;
    }

    public SortingCallbacks $callbacks {
        get => $this->sortingCallbacks ??= new SortingCallbacks($this->_table);
    }

    public null|array|Closure $pasteButtonCallback {
        get => $this->_ref['paste_button_callback'] ?? null;
        set {
            $this->_ref['paste_button_callback'] = $value;
        }
    }

    public null|array|Closure $childRecordCallback {
        get => $this->_ref['child_record_callback'] ?? null;
        set {
            $this->_ref['child_record_callback'] = $value;
        }
    }

    public null|array|Closure $headerCallback {
        get => $this->_ref['header_callback'] ?? null;
        set {
            $this->_ref['header_callback'] = $value;
        }
    }

    public null|array|Closure $panelRecordCallback {
        get => $this->_ref['panel_callback'] ?? null;
        set {
            $this->_ref['panel_callback'] = $value;
        }
    }

    /**
     * @mago-expect analysis:mixed-array-assignment
     * @mago-expect lint:no-global
     * @mago-expect analysis:mixed-property-type-coercion
     */
    public function __construct(string $table)
    {
        $GLOBALS['TL_DCA'][$table]['list']['sorting'] ??= [];

        $this->_table = $table;
        $this->_path = ['TL_DCA', $table, 'list', 'sorting'];
        $this->_ref = &$GLOBALS['TL_DCA'][$table]['list']['sorting'];
    }

    public static function create(string $table): self
    {
        return new static($table);
    }

    /**
     * @param Closure(SortingInterface $sorting, string $table): void $callback
     */
    #[Override]
    public function __invoke(Closure $callback): void
    {
        $callback($this, $this->_table);
    }

    public function addCallback(string|SortingCallback $name, Closure $callback): void
    {
        if ($name instanceof SortingCallback) {
            $name = $name->value;
        }

        $GLOBALS['TL_DCA'][$this->_table]['list']['sorting'][$name] = $callback;
    }
}
