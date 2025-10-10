<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor;

/**
 * @see https://docs.contao.org/dev/reference/dca/list/#labels
 */
final class Label extends DynamicPropertiesInterface
{

    /**
     * One or more fields that will be shown in the list (e.g. ['title', 'user_id:tl_user.name']).
     */
    public array $fields {
        get => $GLOBALS['TL_DCA'][$this->table]['list']['labels']['fields'] ?? [];
        set => $GLOBALS['TL_DCA'][$this->table]['list']['labels']['fields'] = $value;
    }

    /**
     * If true Contao will generate a table header with column names (e.g. back end member list)
     */
    public bool $showColumns {
        get => $GLOBALS['TL_DCA'][$this->table]['list']['labels']['showColumns'] ?? false;
        set => $GLOBALS['TL_DCA'][$this->table]['list']['labels']['showColumns'] = $value;
    }

    public bool $showFirstOrderBy {
        get => $GLOBALS['TL_DCA'][$this->table]['list']['labels']['showFirstOrderBy'] ?? true;
        set => $GLOBALS['TL_DCA'][$this->table]['list']['labels']['showFirstOrderBy'] = $value;
    }

    public string $format {
        get => $GLOBALS['TL_DCA'][$this->table]['list']['labels']['format'] ?? '';
        set => $GLOBALS['TL_DCA'][$this->table]['list']['labels']['format'] = $value;
    }

    public ?int $maxCharacters {
        get => $GLOBALS['TL_DCA'][$this->table]['list']['labels']['maxCharacters'] ?? null;
        set => $GLOBALS['TL_DCA'][$this->table]['list']['labels']['maxCharacters'] = $value;
    }

    public null|\Closure|array $group_callback {
        get => $GLOBALS['TL_DCA'][$this->table]['list']['labels']['group_callback'] ?? null;
        set {
            if (is_callable($value) || null === $value) {
                $GLOBALS['TL_DCA'][$this->table]['list']['labels']['group_callback'] = $value;
            }

            throw new \InvalidArgumentException('The group_callback must be a callable or null.');
        }
    }

    public null|\Closure|array $label_callback {
        get => $GLOBALS['TL_DCA'][$this->table]['list']['labels']['label_callback'] ?? null;
        set {
            if (is_callable($value) || null === $value) {
                $GLOBALS['TL_DCA'][$this->table]['list']['labels']['label_callback'] = $value;
            }

            throw new \InvalidArgumentException('The label_callback must be a callable or null.');
        }
    }

    public function __construct(private readonly string $table)
    {
    }

    public function __get(string $name): mixed
    {
        return $GLOBALS['TL_DCA'][$this->table]['list']['label'][$name] ?? null;
    }

    public function __set(string $name, mixed $value): void
    {
        $GLOBALS['TL_DCA'][$this->table]['list']['label'][$name] = $value;
    }

    public function __isset(string $name): bool
    {
        return isset($GLOBALS['TL_DCA'][$this->table]['list']['label'][$name]);
    }

    public function __unset(string $name): void
    {
        unset($GLOBALS['TL_DCA'][$this->table]['list']['label'][$name]);
    }

    public function addCallback(LabelCallback $name, callable $callback): void
    {
        $GLOBALS['TL_DCA'][$this->table]['list']['label'][$name->value] = $callback;
    }

}
