<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor;

use AllowDynamicProperties;
use Tastaturberuf\ContaoDataContainerAccessor\Callback\ConfigCallback;

/**
 * @see https://docs.contao.org/dev/reference/dca/config/
 */
#[AllowDynamicProperties]
final class Config extends DynamicPropertiesInterface
{

    /**
     * The label is used with page or file trees and typically includes reference to the language array.
     */
    public ?string $label {
        get => $this->__get('label');
        set {
            $this->__set('label', $value);
        }
    }

    /**
     * Name of the related parent table (table.pid = ptable.id).
     */
    public ?string $ptable {
        get => $this->__get('ptable');
        set {
            $this->__set('ptable', $value);
        }
    }

    public ?bool $dynamicPtable {
        get => $this->__get('dynamicPtable');
        set {
            $this->__set('dynamicPtable', $value);
        }
    }

    public ?array $ctable {
        get => $this->__get('ctable');
        set {
            $this->__set('ctable', $value);
        }
    }

    public ?string $dataContainer {
        get => $this->__get('dataContainer');
        set {
            $this->__set('dataContainer', $value);
        }
    }

    public ?string $markAsCopy {
        get => $this->__get('markAsCopy');
        set {
            $this->__set('markAsCopy', $value);
        }
    }

    public ?string $uploadPath {
        get => $this->__get('uploadPath');
        set {
            $this->__set('uploadPath', $value);
        }
    }

    public ?string $validFileTypes {
        get => $this->__get('validFileTypes');
        set {
            $this->__set('validFileTypes', $value);
        }
    }

    public ?string $editableFileTypes {
        get => $this->__get('editableFileTypes');
        set {
            $this->__set('editableFileTypes', $value);
        }
    }

    public ?bool $databaseAssisted {
        get => $this->__get('databaseAssisted');
        set {
            $this->__set('databaseAssisted', $value);
        }
    }

    public ?bool $closed {
        get => $this->__get('closed');
        set {
            $this->__set('closed', $value);
        }
    }

    public ?bool $notEditable {
        get => $this->__get('notEditable');
        set {
            $this->__set('notEditable', $value);
        }
    }

    public ?bool $notDeletable {
        get => $this->__get('notDeletable');
        set {
            $this->__set('notDeletable', $value);
        }
    }

    public ?bool $notSortable {
        get => $this->__get('notSortable');
        set {
            $this->__set('notSortable', $value);
        }
    }

    public ?bool $notCopyable {
        get => $this->__get('notCopyable');
        set {
            $this->__set('notCopyable', $value);
        }
    }

    public ?bool $notCreatable {
        get => $this->__get('notCreatable');
        set {
            $this->__set('notCreatable', $value);
        }
    }

    public ?bool $switchToEdit {
        get => $this->__get('switchToEdit');
        set {
            $this->__set('switchToEdit', $value);
        }
    }

    public ?bool $enableVersioning {
        get => $this->__get('enableVersioning');
        set {
            $this->__set('enableVersioning', $value);
        }
    }

    public ?bool $doNotCopyRecords {
        get => $this->__get('doNotCopyRecords');
        set {
            $this->__set('doNotCopyRecords', $value);
        }
    }

    public ?bool $doNotDeleteRecords {
        get => $this->__get('doNotDeleteRecords');
        set {
            $this->__set('doNotDeleteRecords', $value);
        }
    }

    public ?string $backlink {
        get => $this->__get('backlink');
        set {
            $this->__set('backlink', $value);
        }
    }

    public readonly ConfigCallbacks $callbacks;

    public readonly ConfigSql $sql;

    public function __construct(private readonly string $table)
    {
        $this->sql = new ConfigSql($table);
        $this->callbacks = new ConfigCallbacks($table);
    }

    public function __get(string $name): mixed
    {
        return $GLOBALS['TL_DCA'][$this->table]['config'][$name] ?? null;
    }

    public function __set(string $name, mixed $value): void
    {
        $GLOBALS['TL_DCA'][$this->table]['config'][$name] = $value;
    }

    public function __isset(string $name): bool
    {
        return isset($GLOBALS['TL_DCA'][$this->table]['config'][$name]);
    }

    public function __unset(string $name): void
    {
        unset($GLOBALS['TL_DCA'][$this->table]['config'][$name]);
    }

    public function unset(string $name): void
    {
        $this->__unset($name);
    }

    /**
     * A static factory method to make oneliner possible.
     * This prevents `Fatal error: Cannot use temporary expression in write context ...`
     *
     *     Config::for('tl_test')->ptable = 'tl_parent'
     */
    public static function for(string $table): self
    {
        return new self($table);
    }

    public function addCallback(ConfigCallback $name, callable $callback): void
    {
        $GLOBALS['TL_DCA'][$this->table]['config'][$name->value][] = $callback;
    }

}
