<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor;

/**
 * @see https://docs.contao.org/dev/reference/dca/config/
 */
final class Config extends DynamicPropertiesInterface
{
    private readonly string $_table;

    /**
     * The label is used with page or file trees and typically includes reference to the language array.
     */
    public ?string $label {
        get => $this->__get('label');
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
     * Name of the related parent table (table.pid = ptable.id).
     */
    public ?string $ptable {
        get => $this->__get('ptable');
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
        get => $this->__get('dynamicPtable');
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
        get => $this->__get('ctable');
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
        get => $this->__get('dataContainer');
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
        get => $this->__get('markAsCopy');
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
        get => $this->__get('uploadPath');
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
        get => $this->__get('validFileTypes');
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
        get => $this->__get('editableFileTypes');
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
        get => $this->__get('databaseAssisted');
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
        get => $this->__get('closed');
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
        get => $this->__get('notEditable');
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
        get => $this->__get('notDeletable');
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
        get => $this->__get('notSortable');
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
        get => $this->__get('notCopyable');
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
        get => $this->__get('notCreatable');
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
        get => $this->__get('switchToEdit');
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
        get => $this->__get('enableVersioning');
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
        get => $this->__get('doNotCopyRecords');
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
        get => $this->__get('doNotDeleteRecords');
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
        get => $this->__get('backlink');
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

    public ConfigSql $sql {
        get => $this->sql ?? new ConfigSql($this->_table);
    }

    public function __construct(string $table)
    {
        $this->_table = $table;
    }

    public function __get(string $name): mixed
    {
        return $GLOBALS['TL_DCA'][$this->_table]['config'][$name] ?? null;
    }

    public function __set(string $name, mixed $value): void
    {
        $GLOBALS['TL_DCA'][$this->_table]['config'][$name] = $value;
    }

    public function __isset(string $name): bool
    {
        return isset($GLOBALS['TL_DCA'][$this->_table]['config'][$name]);
    }

    public function __unset(string $name): void
    {
        unset($GLOBALS['TL_DCA'][$this->_table]['config'][$name]);
    }

}
