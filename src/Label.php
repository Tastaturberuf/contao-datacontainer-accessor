<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor;

use Closure;
use Override;
use Tastaturberuf\ContaoDataContainerAccessor\Callback\LabelCallback;
use Tastaturberuf\ContaoDataContainerAccessor\Contracts\LabelInterface;

/**
 * @see https://docs.contao.org/dev/reference/dca/list/#labels
 * @mago-expect analysis:incompatible-property-access
 * @mago-expect analysis:incompatible-readonly-modifier
 */
final class Label extends AbstractAccessor implements LabelInterface
{
    public readonly string $_table;
    public readonly array $_path;
    protected array $_ref;

    /**
     * One or more fields that will be shown in the list (e.g. ['title', 'user_id:tl_user.name']).
     */
    public ?array $fields {
        get => $this->getNullableArray('fields');
        set {
            $this->_ref['fields'] = $value;
        }
    }

    /**
     * One or more fields that will be shown in the list (e.g. ['title', 'user_id:tl_user.name']).
     */
    public function fields(string ...$fields): self
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * If true, Contao will generate a table header with column names (e.g. back end member list)
     */
    public ?bool $showColumns {
        get => $this->getNullableBool('showColumns');
        set {
            $this->_ref['showColumns'] = $value;
        }
    }

    /**
     * If true, Contao will generate a table header with column names (e.g. back end member list)
     */
    public function showColumns(bool $showColumns = true, ?array $fields = null): self
    {
        $this->showColumns = $showColumns;

        if ($fields) {
            $this->fields = $fields;
        }

        return $this;
    }

    /**
     * If false, Contao will not force the first sorting field to show up in the list. (default: true)
     */
    public ?bool $showFirstOrderBy {
        get => $this->getNullableBool('showFirstOrderBy');
        set {
            $this->_ref['showFirstOrderBy'] = $value;
        }
    }

    /**
     * If false, Contao will not force the first sorting field to show up in the list. (default: true)
     */
    public function showFirstOrderBy(bool $enabled = true): self
    {
        $this->showFirstOrderBy = $enabled;

        return $this;
    }

    /**
     * HTML string used to format the fields that will be shown (e.g. `%s (%s)`).
     */
    public ?string $format {
        get => $this->getNullableString('format');
        set {
            $this->_ref['format'] = $value;
        }
    }

    public function format(string $format, ?array $fields = null, ?int $maxCharacters = null): self
    {
        $this->format = $format;

        if ($fields) {
            $this->fields = $fields;
        }

        if ($maxCharacters) {
            $this->maxCharacters = $maxCharacters;
        }

        return $this;
    }

    /**
     * The maximum number of characters to show in the list. (default: null)
     */
    public ?int $maxCharacters {
        get => $this->getNullableInt('maxCharacters');
        set {
            $this->_ref['maxCharacters'] = $value;
        }
    }

    public function maxCharacters(?int $maxCharacters): self
    {
        $this->maxCharacters = $maxCharacters;

        return $this;
    }

    /** @mago-expect analysis:mixed-return-statement */
    public null|array|Closure $groupCallback {
        get => $this->__get('group_callback');
        set {
            $this->_ref['group_callback'] = $value;
        }
    }

    /** @mago-expect analysis:mixed-return-statement */
    public null|array|Closure $labelCallback {
        get => $this->__get('label_callback');
        set {
            $this->_ref['label_callback'] = $value;
        }
    }

    /**
     * @mago-expect analysis:mixed-array-assignment
     * @mago-expect analysis:mixed-property-type-coercion
     * @mago-expect lint:no-global
     */
    public function __construct(string $table)
    {
        $GLOBALS['TL_DCA'][$this->_table]['list']['label'] ??= [];
        $this->_table = $table;
        $this->_path = ['TL_DCA', $this->_table, 'list', 'label'];
        $this->_ref = &$GLOBALS['TL_DCA'][$this->_table]['list']['label'];
    }

    public static function create(string $table): self
    {
        return new self($table);
    }

    /**
     * @param Closure(Label $Label, string $table): void $callback
     */
    #[Override]
    public function __invoke(Closure $callback): void
    {
        $callback($this, $this->_table);
    }

    public function addCallback(LabelCallback $name, Closure $callback): void
    {
        $this->_ref[$name->value] = $callback;
    }
}
