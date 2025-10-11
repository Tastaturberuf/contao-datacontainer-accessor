<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor;

use Tastaturberuf\ContaoDataContainerAccessor\Callback\LabelCallback;

/**
 * @see https://docs.contao.org/dev/reference/dca/list/#labels
 */
final class Label extends DynamicPropertiesInterface
{

    private readonly string $_table;

    /**
     * One or more fields that will be shown in the list (e.g. ['title', 'user_id:tl_user.name']).
     */
    public ?array $fields {
        get => $this->__get('fields');
        set {
            $this->__set('fields', $value);
        }
    }

    /**
     * One or more fields that will be shown in the list (e.g. ['title', 'user_id:tl_user.name']).
     */
    public function fields(array $fields): self
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * If true, Contao will generate a table header with column names (e.g. back end member list)
     */
    public bool $showColumns {
        get => $this->__get('showColumns') ?? false;
        set {
            $this->__set('showColumns', $value);
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
    public bool $showFirstOrderBy {
        get => $this->__get('showFirstOrderBy') ?? true;
        set => $GLOBALS['TL_DCA'][$this->_table]['list']['labels']['showFirstOrderBy'] = $value;
    }

    /**
     * If false, Contao will not force the first sorting field to show up in the list. (default: true)
     */
    public function showFirstOrderBy(bool $showFirstOrderBy = true): self
    {
        $this->showFirstOrderBy = $showFirstOrderBy;

        return $this;
    }

    public function hideFirstOrderBy(): self
    {
        $this->showFirstOrderBy = false;

        return $this;
    }

    /**
     * HTML string used to format the fields that will be shown (e.g. `%s (%s)`).
     */
    public string $format {
        get => $GLOBALS['TL_DCA'][$this->_table]['list']['labels']['format'] ?? '';
        set => $GLOBALS['TL_DCA'][$this->_table]['list']['labels']['format'] = $value;
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
        get => $GLOBALS['TL_DCA'][$this->_table]['list']['labels']['maxCharacters'] ?? null;
        set => $GLOBALS['TL_DCA'][$this->_table]['list']['labels']['maxCharacters'] = $value;
    }

    /**
     * @param int $maxCharacters
     * @return $this
     */
    public function maxCharacters(int $maxCharacters): self
    {
        $this->maxCharacters = $maxCharacters;

        return $this;
    }

    public null|\Closure|array $group_callback {
        get => $GLOBALS['TL_DCA'][$this->_table]['list']['labels']['group_callback'] ?? null;
        set {
            if (is_callable($value) || null === $value) {
                $GLOBALS['TL_DCA'][$this->_table]['list']['labels']['group_callback'] = $value;
            }

            throw new \InvalidArgumentException('The group_callback must be a callable or null.');
        }
    }

    public null|\Closure|array $label_callback {
        get => $GLOBALS['TL_DCA'][$this->_table]['list']['labels']['label_callback'] ?? null;
        set {
            if (is_callable($value) || null === $value) {
                $GLOBALS['TL_DCA'][$this->_table]['list']['labels']['label_callback'] = $value;
            }

            throw new \InvalidArgumentException('The label_callback must be a callable or null.');
        }
    }

    public function __construct(string $table)
    {
        $this->_table = $table;
    }

    public function __get(string $name): mixed
    {
        return $GLOBALS['TL_DCA'][$this->_table]['list']['label'][$name] ?? null;
    }

    public function __set(string $name, mixed $value): void
    {
        $GLOBALS['TL_DCA'][$this->_table]['list']['label'][$name] = $value;
    }

    public function __isset(string $name): bool
    {
        return isset($GLOBALS['TL_DCA'][$this->_table]['list']['label'][$name]);
    }

    public function __unset(string $name): void
    {
        unset($GLOBALS['TL_DCA'][$this->_table]['list']['label'][$name]);
    }

    public function addCallback(LabelCallback $name, callable $callback): void
    {
        $GLOBALS['TL_DCA'][$this->_table]['list']['label'][$name->value] = $callback;
    }

}
