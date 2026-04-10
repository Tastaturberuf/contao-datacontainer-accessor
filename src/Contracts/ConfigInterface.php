<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor\Contracts;

use Closure;
use Tastaturberuf\ContaoDataContainerAccessor\Config\Sql;

/**
 * @api
 */
interface ConfigInterface
{
    /**
     * The label is used with page or file trees and typically includes reference to the language array.
     */
    public ?string $label { get; set(null|string|Closure $label); }

    /**
     * Name of the related parent table `table.pid = ptable.id`.
     */
    public ?string $ptable { get; set; }

    /**
     * Dynamically set the parent table like in `tl_content`.
     */
    public ?bool $dynamicPtable { get; set; }

    /**
     * Name of the related child tables `table.id = ctable.pid`.
     */
    public ?array $ctable { get; set(null|string|array $value); }

    /**
     * `\Contao\DC_Table` (database table), `\Contao\DC_File` (local configuration file) or `\Contao\DC_Folder` (file manager).
     */
    public ?string $dataContainer { get; set; }

    /**
     * Appends “(copy)” to this field when copying a record.
     */
    public ?string $markAsCopy { get; set; }

    /**
     * Path to the root folder of the file manager.
     */
    public ?string $uploadPath { get; set; }

    /**
     * Limits the file manager to certain file types (comma separated list).
     */
    public ?string $validFileTypes { get; set; }

    /**
     * Limits the file types that can be edited with the source code editor (comma separated list).
     */
    public ?string $editableFileTypes { get; set; }

    /**
     * If `true`, the file manager is synchronized with a database table.
     */
    public ?bool $databaseAssisted { get; set; }

    /**
     * If `true`, you cannot add further records to the table.
     */
    public ?bool $closed { get; set; }

    /**
     * If `true`, the table cannot be edited.
     */
    public ?bool $notEditable { get; set; }

    /**
     * If `true`, records in the table cannot be deleted.
     */
    public ?bool $notDeletable { get; set; }

    /**
     * If `true`, records in the table cannot be sorted.
     */
    public ?bool $notSortable { get; set; }

    /**
     * If `true`, records in the table cannot be duplicated.
     */
    public ?bool $notCopyable { get; set; }

    /**
     * If `true`, records in the table cannot be created but can be duplicated.
     */
    public ?bool $notCreatable { get; set; }

    /**
     * Activates the “save and edit” button when a new record is added (sorting mode 4 only).
     */
    public ?bool $switchToEdit { get; set; }

    /**
     * If `true`, Contao saves the old version of a record when a new version is created.
     */
    public ?bool $enableVersioning { get; set; }

    /**
     * If `true`, the version dropdown is hidden.
     */
    public ?bool $hideVersionMenu { get; set; }

    /**
     * If `true`, Contao will not duplicate records of the current table when a record of its parent table is duplicated.
     */
    public ?bool $doNotCopyRecords { get; set; }

    /**
     * If `true`, Contao will not delete records of the current table when a record of its parent table is deleted.
     */
    public ?bool $doNotDeleteRecords { get; set; }

    /**
     * Optional query parameters for the backlink, e.g. `do=news`.
     */
    public ?string $backlink { get; set; }

    /**
     * Only relevant when using `DC_Table` as data container. If `true`, the data is exempt from the backend search.
     *
     * @since Contao 5.7
     */
    public ?bool $backendSearchIgnore { get; set; }

    public Sql $sql { get; set; }

    public array $loadCallback { get; set(array|Closure $callback); }

    public array $createCallback { get; set(array|Closure $callback); }

    public array $beforeSubmitCallback { get; set(array|Closure $callback); }

    public array $submitCallback { get; set(array|Closure $callback); }

    public array $deleteCallback { get; set(array|Closure $callback); }

    public array $cutCallback { get; set(array|Closure $callback); }

    public array $copyCallback { get; set(array|Closure $callback); }

    public array $createVersionCallback { get; set(array|Closure $callback); }

    public array $restoreVersionCallback { get; set(array|Closure $callback); }

    public array $undoCallback { get; set(array|Closure $callback); }

    public array $invalidateCacheTagsCallback { get; set(array|Closure $callback); }

    public array $showCallback { get; set(array|Closure $callback); }

    public array $paletteCallback { get; set(array|Closure $callback); }
}
