<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor;

use Closure;
use Override;
use Tastaturberuf\ContaoDataContainerAccessor\Config\ConfigCallbacks;
use Tastaturberuf\ContaoDataContainerAccessor\Config\Sql;

/**
 * @see https://docs.contao.org/dev/reference/dca/config/
 */
final class Config extends DynamicProperties
{
    public readonly string $_table;

    /**
     * The label is used with page or file trees and typically includes reference to the language array.
     */
    public ?string $label {
        get => $this->_getNullableString('label');
        set {
            $this->__set('label', $value);
        }
    }

    /**
     * The label is used with page or file trees and typically includes reference to the language array.
     *
     * @mago-expect analysis:mixed-array-assignment
     */
    public function label(?string &$label = null): self
    {
        $GLOBALS['TL_DCA'][$this->_table]['config']['label'] = &$label;

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

    /**
     * Name of the related parent table `table.pid = ptable.id`.
     */
    public function ptable(?string $table = null): self
    {
        $this->ptable = $table;

        return $this;
    }

    /**
     * Dynamically set the parent table like in `tl_content`.
     */
    public ?bool $dynamicPtable {
        get => $this->_getNullableBool('dynamicPtable');
        set {
            $this->__set('dynamicPtable', $value);
        }
    }

    /**
     * Dynamically set the parent table like in `tl_content`.
     */
    public function dynamicPtable(bool $enabled = true): self
    {
        $this->dynamicPtable = $enabled;

        return $this;
    }

    /**
     * Name of the related child tables `table.id = ctable.pid`.
     */
    public array $ctable {
        get => $this->_getNullableArray('ctable') ?? [];
        set(string|array $value) {
            $this->__set('ctable', is_array($value) ? $value : [$value]);
        }
    }

    /**
     * Name of the related child tables `table.id = ctable.pid`.
     *
     * @param string|list<string> $table
     */
    public function ctable(string|array $table = [], string ...$tables): self
    {
        if (is_string($table)) {
            $this->ctable = [$table, ...$tables];
        }

        if (is_array($table)) {
            $this->ctable = [...$table, ...$tables];
        }

        return $this;
    }

    /**
     * `\Contao\DC_Table` (database table), `\Contao\DC_File` (local configuration file) or `\Contao\DC_Folder` (file manager).
     */
    public ?string $dataContainer {
        get => $this->_getNullableString('dataContainer');
        set {
            if (null === $value) {
                throw new \InvalidArgumentException(
                    'You must not set the data container to null in ' . $this->_path('dataContainer'),
                );
            }

            $this->__set('dataContainer', $value);
        }
    }

    /**
     * `\Contao\DC_Table` (database table), `\Contao\DC_File` (local configuration file) or `\Contao\DC_Folder` (file manager).
     */
    public function dataContainer(string $class = '\Contao\DC_Table'): self
    {
        $this->dataContainer = $class;

        return $this;
    }

    /**
     * Appends “(copy)” to this field when copying a record.
     */
    public ?string $markAsCopy {
        get => $this->_getNullableString('markAsCopy');
        set {
            $this->__set('markAsCopy', $value);
        }
    }

    /**
     * Appends “(copy)” to this field when copying a record.
     */
    public function markAsCopy(?string $field = null): self
    {
        $this->markAsCopy = $field;

        return $this;
    }

    /**
     * Path to the root folder of the file manager.
     */
    public ?string $uploadPath {
        get => $this->_getNullableString('uploadPath');
        set {
            $this->__set('uploadPath', $value);
        }
    }

    /**
     * Path to the root folder of the file manager.
     */
    public function uploadPath(?string $path = null): self
    {
        $this->uploadPath = $path;

        return $this;
    }

    /**
     * Limits the file manager to certain file types (comma separated list).
     */
    public null|string|array $validFileTypes {
        get => $this->_getNullableString('validFileTypes');
        set {
            $value = is_array($value) ? implode(',', $value) : $value;
            $this->__set('validFileTypes', $value);
        }
    }

    /**
     * Limits the file manager to certain file types (comma separated list).
     *
     * @param null|string|array<string> $extensions
     * @todo add ...$append for straightforward appending?
     */
    public function validFileTypes(null|string|array $extensions = null): self
    {
        if (is_array($extensions)) {
            $extensions = implode(',', $extensions);
        }

        $this->validFileTypes = $extensions;

        return $this;
    }

    /**
     * Limits the file types that can be edited with the source code editor (comma separated list).
     */
    public ?string $editableFileTypes {
        get => $this->_getNullableString('editableFileTypes');
        set(null|string|array $value) {
            $value = is_array($value) ? implode(',', $value) : $value;
            $this->__set('editableFileTypes', $value);
        }
    }

    /**
     * Limits the file types that can be edited with the source code editor (comma separated list).
     *
     * @param null|string|array<string> $extensions
     */
    public function editableFileTypes(null|string|array $extensions = null): self
    {
        if (is_array($extensions)) {
            $extensions = implode(',', $extensions);
        }

        $this->editableFileTypes = $extensions;

        return $this;
    }

    /**
     * If `true`, the file manager is synchronized with a database table.
     */
    public ?bool $databaseAssisted {
        get => $this->_getNullableBool('databaseAssisted');
        set {
            $this->__set('databaseAssisted', $value);
        }
    }

    /**
     * If `true`, the file manager is synchronized with a database table.
     */
    public function databaseAssisted(bool $enabled = true): self
    {
        $this->databaseAssisted = $enabled;

        return $this;
    }

    /**
     * If `true`, you cannot add further records to the table.
     */
    public ?bool $closed {
        get => $this->_getNullableBool('closed');
        set {
            $this->__set('closed', $value);
        }
    }

    /**
     * If `true`, you cannot add further records to the table.
     */
    public function closed(bool $enabled = true): self
    {
        $this->closed = $enabled;

        return $this;
    }

    /**
     * If `true`, the table cannot be edited.
     */
    public ?bool $notEditable {
        get => $this->_getNullableBool('notEditable');
        set {
            $this->__set('notEditable', $value);
        }
    }

    /**
     * If `true`, the table cannot be edited.
     */
    public function notEditable(bool $enabled = true): self
    {
        $this->notEditable = $enabled;

        return $this;
    }

    /**
     * If `true`, records in the table cannot be deleted.
     */
    public ?bool $notDeletable {
        get => $this->_getNullableBool('notDeletable');
        set {
            $this->__set('notDeletable', $value);
        }
    }

    /**
     * If `true`, records in the table cannot be deleted.
     */
    public function notDeletable(bool $enabled = true): self
    {
        $this->notDeletable = $enabled;

        return $this;
    }

    /**
     * If `true`, records in the table cannot be sorted.
     */
    public ?bool $notSortable {
        get => $this->_getNullableBool('notSortable');
        set {
            $this->__set('notSortable', $value);
        }
    }

    /**
     * If `true`, records in the table cannot be sorted.
     */
    public function notSortable(bool $enabled = true): self
    {
        $this->notSortable = $enabled;

        return $this;
    }

    /**
     * If `true`, records in the table cannot be duplicated.
     */
    public ?bool $notCopyable {
        get => $this->_getNullableBool('notCopyable');
        set {
            $this->__set('notCopyable', $value);
        }
    }

    /**
     * If `true`, records in the table cannot be duplicated.
     */
    public function notCopyable(bool $enabled = true): self
    {
        $this->notCopyable = $enabled;

        return $this;
    }

    /**
     * If `true, records in the table cannot be created but can be duplicated.
     */
    public ?bool $notCreatable {
        get => $this->_getNullableBool('notCreatable');
        set {
            $this->__set('notCreatable', $value);
        }
    }

    /**
     * If `true`, records in the table cannot be created but can be duplicated.
     */
    public function notCreatable(bool $enabled = true): self
    {
        $this->notCreatable = $enabled;

        return $this;
    }

    /**
     * Activates the “save and edit” button when a new record is added (sorting mode 4 only).
     */
    public ?bool $switchToEdit {
        get => $this->_getNullableBool('switchToEdit');
        set {
            $this->__set('switchToEdit', $value);
        }
    }

    /**
     * Activates the “save and edit” button when a new record is added (sorting mode 4 only).
     */
    public function switchToEdit(bool $enabled = true): self
    {
        $this->switchToEdit = $enabled;

        return $this;
    }

    /**
     * If `true`, Contao saves the old version of a record when a new version is created.
     */
    public ?bool $enableVersioning {
        get => $this->_getNullableBool('enableVersioning');
        set {
            $this->__set('enableVersioning', $value);
        }
    }

    /**
     * If `true`, Contao saves the old version of a record when a new version is created.
     */
    public function enableVersioning(bool $enabled = true): self
    {
        $this->enableVersioning = $enabled;

        return $this;
    }

    /**
     * If `true`, the version dropdown is hidden.
     */
    public ?bool $hideVersionMenu {
        get => $this->_getNullableBool('hideVersionMenu');
        set {
            $this->__set('hideVersionMenu', $value);
        }
    }

    /**
     * If `true`, the version dropdown is hidden.
     */
    public function hideVersionMenu(bool $enabled = true): self
    {
        $this->hideVersionMenu = $enabled;

        return $this;
    }

    /**
     * If `true`, Contao will not duplicate records of the current table when a record of its parent table is duplicated.
     */
    public ?bool $doNotCopyRecords {
        get => $this->_getNullableBool('doNotCopyRecords');
        set {
            $this->__set('doNotCopyRecords', $value);
        }
    }

    /**
     * If `true`, Contao will not duplicate records of the current table when a record of its parent table is duplicated.
     */
    public function doNotCopyRecords(bool $enabled = true): self
    {
        $this->doNotCopyRecords = $enabled;

        return $this;
    }

    /**
     * If `true`, Contao will not delete records of the current table when a record of its parent table is deleted.
     */
    public ?bool $doNotDeleteRecords {
        get => $this->_getNullableBool('doNotDeleteRecords');
        set {
            $this->__set('doNotDeleteRecords', $value);
        }
    }

    /**
     * If `true`, Contao will not delete records of the current table when a record of its parent table is deleted.
     */
    public function doNotDeleteRecords(bool $enabled = true): self
    {
        $this->doNotDeleteRecords = $enabled;

        return $this;
    }

    /**
     * Optional query parameters for the backlink, e.g. `do=news`.
     */
    public ?string $backlink {
        get => $this->_getNullableString('backlink');
        set {
            $this->__set('backlink', $value);
        }
    }

    /**
     * Optional query parameters for the backlink, e.g. `do=news`.
     *
     * @todo allow array?
     */
    public function backlink(?string $query = null): self
    {
        $this->backlink = $query;

        return $this;
    }

    /**
     * Only relevant when using `DC_Table` as data container. If `true`, the data is exempt from the backend search.
     *
     * @since Contao 5.7
     */
    public ?bool $backendSearchIgnore {
        get => $this->_getNullableBool('backendSearchIgnore');
        set {
            $this->__set('backendSearchIgnore', $value);
        }
    }

    /**
     * Only relevant when using `DC_Table` as data container. If `true`, the data is exempt from the backend search.
     *
     * @since Contao 5.7
     */
    public function backendSearchIgnore(bool $enabled = true): self
    {
        $this->backendSearchIgnore = $enabled;

        return $this;
    }

    /**
     * @todo find a better solution
     */
    public ConfigCallbacks $callbacks {
        get => $this->callbacks ?? new ConfigCallbacks($this->_table);
    }

    public array|Sql $sql {
        get => $this->sql ?? new Sql($this->_table);
        set(null|array|Sql $value) {
            if ($value instanceof Sql) {
                $this->sql = $value;
            } else {
                $this->__set('sql', $value);
            }
        }
    }

    /**
     * @param null|array|callable(Sql $sql, string $table): void $callback
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

    public static function create(string $table): self
    {
        return new static($table);
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

    /**
     * @param Closure(self $config, string $table): void $callback
     */
    public function __invoke(Closure $callback): self
    {
        $callback($this, $this->_table);

        return $this;
    }

    #[Override]
    protected function _path(string $name): string
    {
        return "\$GLOBALS['TL_DCA']['$this->_table']['config']['$name']";
    }
}
