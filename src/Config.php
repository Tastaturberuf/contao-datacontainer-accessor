<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor;

use Override;

/**
 * @see https://docs.contao.org/dev/reference/dca/config/
 */
final class Config extends DynamicProperties
{
    private readonly string $_table;

    /**
     * The label is used with page or file trees and typically includes reference to the language array.
     */
    public ?string $label {
        get => $this->_getNullableString('label');
        set {
            $this->__set('label', $value);
        }
    }

    public function label(?string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Name of the related parent table `table.pid = ptable.id`.
     */
    public ?string $ptable {
        get => $this->_getNullableString('ptable');
        set {
            $this->__set('ptable', $value);
        }
    }

    public function ptable(?string $ptable): self
    {
        $this->ptable = $ptable;

        return $this;
    }

    public ?bool $dynamicPtable {
        get => $this->_getNullableBool('dynamicPtable');
        set {
            $this->__set('dynamicPtable', $value);
        }
    }

    public function dynamicPtable(bool $dynamicPtable = true): self
    {
        $this->dynamicPtable = $dynamicPtable;

        return $this;
    }

    public ?array $ctable {
        get => $this->_getNullableArray('ctable');
        set {
            $this->__set('ctable', $value);
        }
    }

    public function ctable(?array $ctable): self
    {
        $this->ctable = $ctable;

        return $this;
    }

    public ?string $dataContainer {
        get => $this->_getNullableString('dataContainer');
        set {
            $this->__set('dataContainer', $value);
        }
    }

    public function dataContainer(?string $dataContainer = 'Contao\DC_Table'): self
    {
        $this->dataContainer = $dataContainer;

        return $this;
    }

    public ?string $markAsCopy {
        get => $this->_getNullableString('markAsCopy');
        set {
            $this->__set('markAsCopy', $value);
        }
    }

    public function markAsCopy(?string $markAsCopy): self
    {
        $this->markAsCopy = $markAsCopy;

        return $this;
    }

    public ?string $uploadPath {
        get => $this->_getNullableString('uploadPath');
        set {
            $this->__set('uploadPath', $value);
        }
    }

    public function uploadPath(?string $uploadPath): self
    {
        $this->uploadPath = $uploadPath;

        return $this;
    }

    public ?string $validFileTypes {
        get => $this->_getNullableString('validFileTypes');
        set {
            $this->__set('validFileTypes', $value);
        }
    }

    public function validFileTypes(?string $validFileTypes): self
    {
        $this->validFileTypes = $validFileTypes;

        return $this;
    }

    public ?string $editableFileTypes {
        get => $this->_getNullableString('editableFileTypes');
        set {
            $this->__set('editableFileTypes', $value);
        }
    }

    public function editableFileTypes(?string $editableFileTypes): self
    {
        $this->editableFileTypes = $editableFileTypes;

        return $this;
    }

    public ?bool $databaseAssisted {
        get => $this->_getNullableBool('databaseAssisted');
        set {
            $this->__set('databaseAssisted', $value);
        }
    }

    public function databaseAssisted(bool $databaseAssisted = true): self
    {
        $this->databaseAssisted = $databaseAssisted;

        return $this;
    }

    public ?bool $closed {
        get => $this->_getNullableBool('closed');
        set {
            $this->__set('closed', $value);
        }
    }

    public function closed(bool $closed = true): self
    {
        $this->closed = $closed;

        return $this;
    }

    public ?bool $notEditable {
        get => $this->_getNullableBool('notEditable');
        set {
            $this->__set('notEditable', $value);
        }
    }

    public function notEditable(bool $notEditable = true): self
    {
        $this->notEditable = $notEditable;

        return $this;
    }

    public ?bool $notDeletable {
        get => $this->_getNullableBool('notDeletable');
        set {
            $this->__set('notDeletable', $value);
        }
    }

    public function notDeletable(bool $notDeletable = true): self
    {
        $this->notDeletable = $notDeletable;

        return $this;
    }

    public ?bool $notSortable {
        get => $this->_getNullableBool('notSortable');
        set {
            $this->__set('notSortable', $value);
        }
    }

    public function notSortable(bool $notSortable = true): self
    {
        $this->notSortable = $notSortable;

        return $this;
    }

    public ?bool $notCopyable {
        get => $this->_getNullableBool('notCopyable');
        set {
            $this->__set('notCopyable', $value);
        }
    }

    public function notCopyable(bool $notCopyable = true): self
    {
        $this->notCopyable = $notCopyable;

        return $this;
    }

    public ?bool $notCreatable {
        get => $this->_getNullableBool('notCreatable');
        set {
            $this->__set('notCreatable', $value);
        }
    }

    public function notCreatable(bool $notCreatable = true): self
    {
        $this->notCreatable = $notCreatable;

        return $this;
    }

    public ?bool $switchToEdit {
        get => $this->_getNullableBool('switchToEdit');
        set {
            $this->__set('switchToEdit', $value);
        }
    }

    public function switchToEdit(bool $switchToEdit = true): self
    {
        $this->switchToEdit = $switchToEdit;

        return $this;
    }

    public ?bool $enableVersioning {
        get => $this->_getNullableBool('enableVersioning');
        set {
            $this->__set('enableVersioning', $value);
        }
    }

    public function enableVersioning(bool $enableVersioning = true): self
    {
        $this->enableVersioning = $enableVersioning;

        return $this;
    }

    public ?bool $doNotCopyRecords {
        get => $this->_getNullableBool('doNotCopyRecords');
        set {
            $this->__set('doNotCopyRecords', $value);
        }
    }

    public function doNotCopyRecords(bool $doNotCopyRecords = true): self
    {
        $this->doNotCopyRecords = $doNotCopyRecords;

        return $this;
    }

    public ?bool $doNotDeleteRecords {
        get => $this->_getNullableBool('doNotDeleteRecords');
        set {
            $this->__set('doNotDeleteRecords', $value);
        }
    }

    public function doNotDeleteRecords(bool $doNotDeleteRecords = true): self
    {
        $this->doNotDeleteRecords = $doNotDeleteRecords;

        return $this;
    }

    public ?string $backlink {
        get => $this->_getNullableString('backlink');
        set {
            $this->__set('backlink', $value);
        }
    }

    public function backlink(?string $backlink): self
    {
        $this->backlink = $backlink;

        return $this;
    }

    public ConfigCallbacks $callbacks {
        get => $this->callbacks ?? new ConfigCallbacks($this->_table);
    }

    public array|ConfigSql $sql {
        get => $this->sql ?? new ConfigSql($this->_table);
        set(null|array|ConfigSql $value) {
            if ($value instanceof ConfigSql) {
                $this->sql = $value;
            } else {
                $this->__set('sql', $value);
            }
        }
    }

    /**
     * @param null|array|callable(ConfigSql $sql, string $table): void $callback
     */
    public function sql(null|array|callable $callback): self
    {
        if (is_callable($callback)) {
            $callback($this->sql, $this->_table);
        } else {
            $this->__set('sql', $callback);
        }

        return $this;
    }

    public function __construct(string $table)
    {
        $this->_table = $table;
    }

    #[Override]
    public function __get(string $name): mixed
    {
        return $GLOBALS['TL_DCA'][$this->_table]['config'][$name] ?? null;
    }

    /**
     * @mago-expect analysis:mixed-array-assignment
     */
    #[Override]
    public function __set(string $name, mixed $value): void
    {
        $GLOBALS['TL_DCA'][$this->_table]['config'][$name] = $value;
    }

    #[Override]
    public function __isset(string $name): bool
    {
        return isset($GLOBALS['TL_DCA'][$this->_table]['config'][$name]);
    }

    /**
     * @mago-expect analysis:mixed-array-access
     */
    #[Override]
    public function __unset(string $name): void
    {
        unset($GLOBALS['TL_DCA'][$this->_table]['config'][$name]);
    }

    #[Override]
    protected function _path(string $name): string
    {
        return "\$GLOBALS['TL_DCA']['$this->_table']['config']['$name']";
    }
}
