<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor;

use Closure;
use InvalidArgumentException;
use Override;
use Tastaturberuf\ContaoDataContainerAccessor\Callback\ConfigCallback;
use Tastaturberuf\ContaoDataContainerAccessor\Config\Sql;
use Tastaturberuf\ContaoDataContainerAccessor\Contracts\ConfigInterface;
use function is_array;

/**
 * @see https://docs.contao.org/dev/reference/dca/config/
 * @mago-expect analysis:incompatible-readonly-modifier
 * @mago-expect analysis:incompatible-property-access
 * @mago-expect analysis:mixed-return-statement
 */
final class Config extends AbstractAccessor implements ConfigInterface
{
    public readonly string $_table;
    public readonly array $_path;
    protected array $_ref;

    /**
     * The label is used with page or file trees and typically includes reference to the language array.
     */
    public ?string $label {
        get => $this->_ref['label'] ?? null;
        set(null|string|Closure $value) {
            if ($value instanceof Closure) {
                $this->_ref['label'] = &$value();
                return;
            }

            $this->_ref['label'] = $value;
        }
    }

    /**
     * The label is used with page or file trees and typically includes reference to the language array.
     */
    public function label(?string &$label = null): self
    {
        $this->_ref['label'] = &$label;

        return $this;
    }

    /**
     * Name of the related parent table `table.pid = ptable.id`.
     */

    public ?string $ptable {
        get => $this->_ref['ptable'] ?? null;
        set {
            $this->_ref['ptable'] = $value;
        }
    }

    /**
     * Name of the related parent table `table.pid = ptable.id`.
     */
    public function ptable(?string $table = null): self
    {
        $this->_ref['ptable'] = $table;

        return $this;
    }

    /**
     * Dynamically set the parent table like in `tl_content`.
     */
    public ?bool $dynamicPtable {
        get => $this->_ref['dynamicPtable'] ?? null;
        set {
            $this->_ref['dynamicPtable'] = $value;
        }
    }

    /**
     * Dynamically set the parent table like in `tl_content`.
     */
    public function dynamicPtable(bool $enabled = true): self
    {
        $this->_ref['dynamicPtable'] = $enabled;

        return $this;
    }

    /**
     * Name of the related child tables `table.id = ctable.pid`.
     */
    public ?array $ctable {
        get => $this->_ref['ctable'] ?? null;
        set(null|array|string $value) {
            if (null === $value) {
                $this->_ref['ctable'] = null;
                return;
            }

            $this->_ref['ctable'] = is_array($value) ? $value : [$value];
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
            $this->_ref['ctable'] = [$table, ...$tables];
        }

        if (is_array($table)) {
            $this->_ref['ctable'] = [...$table, ...$tables];
        }

        return $this;
    }

    /**
     * `\Contao\DC_Table` (database table), `\Contao\DC_File` (local configuration file) or `\Contao\DC_Folder` (file manager).
     */
    public ?string $dataContainer {
        get => $this->_ref['dataContainer'] ?? null;
        set {
            if (null === $value) {
                throw new InvalidArgumentException('Do not set the data container to null');
            }

            $this->_ref['dataContainer'] = $value;
        }
    }

    /**
     * `\Contao\DC_Table` (database table), `\Contao\DC_File` (local configuration file) or `\Contao\DC_Folder` (file manager).
     */
    public function dataContainer(string $class = '\Contao\DC_Table'): self
    {
        $this->_ref['dataContainer'] = $class;

        return $this;
    }

    /**
     * Appends “(copy)” to this field when copying a record.
     */
    public ?string $markAsCopy {
        get => $this->_ref['markAsCopy'] ?? null;
        set {
            $this->_ref['markAsCopy'] = $value;
        }
    }

    /**
     * Appends “(copy)” to this field when copying a record.
     */
    public function markAsCopy(?string $field = null): self
    {
        $this->_ref['markAsCopy'] = $field;

        return $this;
    }

    /**
     * Path to the root folder of the file manager.
     */
    public ?string $uploadPath {
        get => $this->_ref['uploadPath'] ?? null;
        set {
            $this->_ref['uploadPath'] = $value;
        }
    }

    /**
     * Path to the root folder of the file manager.
     */
    public function uploadPath(?string $path = null): self
    {
        $this->_ref['uploadPath'] = $path;

        return $this;
    }

    /**
     * Limits the file manager to certain file types (comma separated list).
     */
    public ?string $validFileTypes {
        get => $this->_ref['validFileTypes'] ?? null;
        set(null|string|array $value) {
            $value = is_array($value) ? implode(',', $value) : $value;
            $this->_ref['validFileTypes'] = $value;
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

        $this->_ref['validFileTypes'] = $extensions;

        return $this;
    }

    /**
     * Limits the file types that can be edited with the source code editor (comma separated list).
     */
    public ?string $editableFileTypes {
        get => $this->_ref['editableFileTypes'] ?? null;
        set(null|string|array $value) {
            $value = is_array($value) ? implode(',', $value) : $value;
            $this->_ref['editableFileTypes'] = $value;
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

        $this->_ref['editableFileTypes'] = $extensions;

        return $this;
    }

    /**
     * If `true`, the file manager is synchronized with a database table.
     */
    public ?bool $databaseAssisted {
        get => $this->_ref['databaseAssisted'] ?? null;
        set {
            $this->_ref['databaseAssisted'] = $value;
        }
    }

    /**
     * If `true`, the file manager is synchronized with a database table.
     */
    public function databaseAssisted(bool $enabled = true): self
    {
        $this->_ref['databaseAssisted'] = $enabled;

        return $this;
    }

    /**
     * If `true`, you cannot add further records to the table.
     */
    public ?bool $closed {
        get => $this->_ref['closed'] ?? null;
        set {
            $this->_ref['closed'] = $value;
        }
    }

    /**
     * If `true`, you cannot add further records to the table.
     */
    public function closed(bool $enabled = true): self
    {
        $this->_ref['closed'] = $enabled;

        return $this;
    }

    /**
     * If `true`, the table cannot be edited.
     */
    public ?bool $notEditable {
        get => $this->_ref['notEditable'] ?? null;
        set {
            $this->_ref['notEditable'] = $value;
        }
    }

    /**
     * If `true`, the table cannot be edited.
     */
    public function notEditable(bool $enabled = true): self
    {
        $this->_ref['notEditable'] = $enabled;

        return $this;
    }

    /**
     * If `true`, records in the table cannot be deleted.
     */
    public ?bool $notDeletable {
        get => $this->_ref['notDeletable'] ?? null;
        set {
            $this->_ref['notDeletable'] = $value;
        }
    }

    /**
     * If `true`, records in the table cannot be deleted.
     */
    public function notDeletable(bool $enabled = true): self
    {
        $this->_ref['notDeletable'] = $enabled;

        return $this;
    }

    /**
     * If `true`, records in the table cannot be sorted.
     */
    public ?bool $notSortable {
        get => $this->_ref['notSortable'] ?? null;
        set {
            $this->_ref['notSortable'] = $value;
        }
    }

    /**
     * If `true`, records in the table cannot be sorted.
     */
    public function notSortable(bool $enabled = true): self
    {
        $this->_ref['notSortable'] = $enabled;

        return $this;
    }

    /**
     * If `true`, records in the table cannot be duplicated.
     */
    public ?bool $notCopyable {
        get => $this->_ref['notCopyable'] ?? null;
        set {
            $this->_ref['notCopyable'] = $value;
        }
    }

    /**
     * If `true`, records in the table cannot be duplicated.
     */
    public function notCopyable(bool $enabled = true): self
    {
        $this->_ref['notCopyable'] = $enabled;

        return $this;
    }

    /**
     * If `true`, records in the table cannot be created but can be duplicated.
     */
    public ?bool $notCreatable {
        get => $this->_ref['notCreatable'] ?? null;
        set {
            $this->_ref['notCreatable'] = $value;
        }
    }

    /**
     * If `true`, records in the table cannot be created but can be duplicated.
     */
    public function notCreatable(bool $enabled = true): self
    {
        $this->_ref['notCreatable'] = $enabled;

        return $this;
    }

    /**
     * Activates the “save and edit” button when a new record is added (sorting mode 4 only).
     */
    public ?bool $switchToEdit {
        get => $this->_ref['switchToEdit'] ?? null;
        set {
            $this->_ref['switchToEdit'] = $value;
        }
    }

    /**
     * Activates the “save and edit” button when a new record is added (sorting mode 4 only).
     */
    public function switchToEdit(bool $enabled = true): self
    {
        $this->_ref['switchToEdit'] = $enabled;

        return $this;
    }

    /**
     * If `true`, Contao saves the old version of a record when a new version is created.
     */
    public ?bool $enableVersioning {
        get => $this->_ref['enableVersioning'] ?? null;
        set {
            $this->_ref['enableVersioning'] = $value;
        }
    }

    /**
     * If `true`, Contao saves the old version of a record when a new version is created.
     */
    public function enableVersioning(bool $enabled = true): self
    {
        $this->_ref['enableVersioning'] = $enabled;

        return $this;
    }

    /**
     * If `true`, the version dropdown is hidden.
     */
    public ?bool $hideVersionMenu {
        get => $this->_ref['hideVersionMenu'] ?? null;
        set {
            $this->_ref['hideVersionMenu'] = $value;
        }
    }

    /**
     * If `true`, the version dropdown is hidden.
     */
    public function hideVersionMenu(bool $enabled = true): self
    {
        $this->_ref['hideVersionMenu'] = $enabled;

        return $this;
    }

    /**
     * If `true`, Contao will not duplicate records of the current table when a record of its parent table is duplicated.
     */
    public ?bool $doNotCopyRecords {
        get => $this->_ref['doNotCopyRecords'] ?? null;
        set {
            $this->_ref['doNotCopyRecords'] = $value;
        }
    }

    /**
     * If `true`, Contao will not duplicate records of the current table when a record of its parent table is duplicated.
     */
    public function doNotCopyRecords(bool $enabled = true): self
    {
        $this->_ref['doNotCopyRecords'] = $enabled;

        return $this;
    }

    /**
     * If `true`, Contao will not delete records of the current table when a record of its parent table is deleted.
     */
    public ?bool $doNotDeleteRecords {
        get => $this->_ref['doNotDeleteRecords'] ?? null;
        set {
            $this->_ref['doNotDeleteRecords'] = $value;
        }
    }

    /**
     * If `true`, Contao will not delete records of the current table when a record of its parent table is deleted.
     */
    public function doNotDeleteRecords(bool $enabled = true): self
    {
        $this->_ref['doNotDeleteRecords'] = $enabled;

        return $this;
    }

    /**
     * Optional query parameters for the backlink, e.g. `do=news`.
     */
    public ?string $backlink {
        get => $this->_ref['backlink'] ?? null;
        set {
            $this->_ref['backlink'] = $value;
        }
    }

    /**
     * Optional query parameters for the backlink, e.g. `do=news`.
     *
     * @todo allow array?
     */
    public function backlink(?string $query = null): self
    {
        $this->_ref['backlink'] = $query;

        return $this;
    }

    /**
     * Only relevant when using `DC_Table` as data container. If `true`, the data is exempt from the backend search.
     *
     * @since Contao 5.7
     */
    public ?bool $backendSearchIgnore {
        get => $this->_ref['backendSearchIgnore'] ?? null;
        set {
            $this->_ref['backendSearchIgnore'] = $value;
        }
    }

    /**
     * Only relevant when using `DC_Table` as data container. If `true`, the data is exempt from the backend search.
     *
     * @since Contao 5.7
     */
    public function backendSearchIgnore(bool $enabled = true): self
    {
        $this->_ref['backendSearchIgnore'] = $enabled;

        return $this;
    }

    public Sql $sql {
        get => $this->sql ??= new Sql($this->_table);
        set(array|Sql|Closure $value) {
            if ($value instanceof Sql) {
                $this->sql = $value;
            }

            if (is_array($value)) {
                $this->_ref['sql'] = $value;
            }

            if ($value instanceof Closure) {
                $this->sql ??= new Sql($this->_table);
                $this->sql->__invoke($value);
            }
        }
    }

    /**
     * @param null|array|callable(Sql $sql, string $table): void $callback
     */
    public function sql(null|array|callable $callback): self
    {
        if (is_callable($callback)) {
            $this->sql->__invoke($callback);
        } else {
            $this->__set('sql', $callback);
        }

        return $this;
    }

    /** @mago-expect analysis:mixed-array-assignment */
    public array $loadCallback {
        get => $this->_ref['onload_callback'] ?? [];
        set(array|Closure $value) {
            $this->_ref['onload_callback'][] = $value;
        }
    }

    /** @mago-expect analysis:mixed-array-assignment */
    public array $createCallback {
        get => $this->_ref['oncreate_callback'] ?? [];
        set(array|Closure $value) {
            $this->_ref['oncreate_callback'][] = $value;
        }
    }

    /** @mago-expect analysis:mixed-array-assignment */
    public array $beforeSubmitCallback {
        get => $this->_ref['onbeforesubmit_callback'] ?? [];
        set(array|Closure $value) {
            $this->_ref['onbeforesubmit_callback'][] = $value;
        }
    }

    /** @mago-expect analysis:mixed-array-assignment */
    public array $submitCallback {
        get => $this->_ref['onsubmit_callback'] ?? [];
        set(array|Closure $value) {
            $this->_ref['onsubmit_callback'][] = $value;
        }
    }

    /** @mago-expect analysis:mixed-array-assignment */
    public array $deleteCallback {
        get => $this->_ref['ondelete_callback'] ?? [];
        set(array|Closure $value) {
            $this->_ref['ondelete_callback'][] = $value;
        }
    }

    /** @mago-expect analysis:mixed-array-assignment */
    public array $cutCallback {
        get => $this->_ref['oncut_callback'] ?? [];
        set(array|Closure $value) {
            $this->_ref['oncut_callback'][] = $value;
        }
    }

    /** @mago-expect analysis:mixed-array-assignment */
    public array $copyCallback {
        get => $this->_ref['oncopy_callback'] ?? [];
        set(array|Closure $value) {
            $this->_ref['oncopy_callback'][] = $value;
        }
    }

    /** @mago-expect analysis:mixed-array-assignment */
    public array $createVersionCallback {
        get => $this->_ref['oncreate_version_callback'] ?? [];
        set(array|Closure $value) {
            $this->_ref['oncreate_version_callback'][] = $value;
        }
    }

    /** @mago-expect analysis:mixed-array-assignment */
    public array $restoreVersionCallback {
        get => $this->_ref['onrestore_version_callback'] ?? [];
        set(array|Closure $value) {
            $this->_ref['onrestore_version_callback'][] = $value;
        }
    }

    /** @mago-expect analysis:mixed-array-assignment */
    public array $undoCallback {
        get => $this->_ref['onundo_callback'] ?? [];
        set(array|Closure $value) {
            $this->_ref['onundo_callback'][] = $value;
        }
    }

    /** @mago-expect analysis:mixed-array-assignment */
    public array $invalidateCacheTagsCallback {
        get => $this->_ref['oninvalidatecache_tags_callback'] ?? [];
        set(array|Closure $value) {
            $this->_ref['oninvalidatecache_tags_callback'][] = $value;
        }
    }

    /** @mago-expect analysis:mixed-array-assignment */
    public array $showCallback {
        get => $this->_ref['onshow_callback'] ?? [];
        set(array|Closure $value) {
            $this->_ref['onshow_callback'][] = $value;
        }
    }

    /** @mago-expect analysis:mixed-array-assignment */
    public array $paletteCallback {
        get => $this->_ref['onpalette_callback'] ?? [];
        set(array|Closure $value) {
            $this->_ref['onpalette_callback'][] = $value;
        }
    }

    /**
     * @mago-expect analysis:mixed-array-assignment
     * @mago-expect analysis:mixed-property-type-coercion
     */
    public function __construct(string $table)
    {
        $GLOBALS['TL_DCA'][$table]['config'] ??= [];

        $this->_table = $table;
        $this->_path = ['TL_DCA', $this->_table, 'config'];
        $this->_ref = &$GLOBALS['TL_DCA'][$table]['config'];
    }

    public static function create(string $table): self
    {
        return new static($table);
    }

    /**
     * @param Closure(ConfigInterface $config, string $table): void $callback
     */
    #[Override]
    public function __invoke(Closure $callback): void
    {
        $callback($this, $this->_table);
    }

    /** @mago-expect analysis:mixed-array-assignment */
    public function addCallback(string|ConfigCallback $name, Closure $callback): void
    {
        if ($name instanceof ConfigCallback) {
            $name = $name->value;
        }

        $this->_ref[$name][] = $callback;
    }
}
