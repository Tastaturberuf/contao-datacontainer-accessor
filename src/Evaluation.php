<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor;

/**
 * @see https://docs.contao.org/5.x/dev/reference/dca/fields/#evaluation
 */
final class Evaluation extends DynamicPropertiesInterface
{

    private readonly string $_table;
    private readonly string $_field;

    /**
     * If true, the current field will accept HTML input (see “Allowed HTML tags” in the back end System => Settings).
     */
    public ?bool $allowHtml {
        get => $this->__get('allowHtml');
        set {
            $this->__set('allowHtml', $value);
        }
    }

    public function allowHtml(bool $allowHtml = true): self
    {
        $this->allowHtml = $allowHtml;

        return $this;
    }

    /**
     * If true, the field will always be saved, even if its value has not changed. This can be useful in conjunction with a load callback.
     */
    public ?bool $alwaysSave {
        get => $this->__get('alwaysSave');
        set {
            $this->__set('alwaysSave', $value);
        }
    }

    public function alwaysSave(bool $alwaysSave = true): self
    {
        $this->alwaysSave = $alwaysSave;

        return $this;
    }

    /**
     * If true, converts basic entities like `&shy;`, `&amp;` etc. back to their Contao representation `[&]`, `[-]` etc. when editing and vice versa when saving.
     */
    public ?bool $basicEntities {
        get => $this->__get('basicEntities');
        set {
            $this->__set('basicEntities', $value);
        }
    }

    public function basicEntities(bool $basicEntities = true): self
    {
        $this->basicEntities = $basicEntities;

        return $this;
    }

    /**
     * Label for the blank option (defaults to `-`).
     */
    public ?string $blankOptionLabel {
        get => $this->__get('blankOptionLabel');
        set {
            $this->__set('blankOptionLabel', $value);
        }
    }

    public function blankOptionLabel(string $blankOptionLabel): self
    {
        $this->blankOptionLabel = $blankOptionLabel;

        return $this;
    }

    /**
     * Native selects enhanced with Chosen.
     */
    public ?bool $chosen {
        get => $this->__get('chosen');
        set {
            $this->__set('chosen', $value);
        }
    }

    public function chosen(bool $chosen = true): self
    {
        $this->chosen = $chosen;

        return $this;
    }

    /**
     * If true, all option groups without at least one checked option will be collapsed. The first group of options will not be collapsed if there are no options selected at all. Applies to checkbox widgets with a nested array of options only.
     */
    public ?bool $collapseUncheckedGroups {
        get => $this->__get('collapseUncheckedGroups');
        set {
            $this->__set('collapseUncheckedGroups', $value);
        }
    }

    public function collapseUncheckedGroups(bool $collapseUncheckedGroups = true): self
    {
        $this->collapseUncheckedGroups = $collapseUncheckedGroups;

        return $this;
    }

    /**
     * If true, the current field will have a mooRainbow color picker.
     */
    public ?bool $colorPicker {
        get => $this->__get('colorpicker');
        set {
            $this->__set('colorpicker', $value);
        }
    }

    public function colorPicker(bool $colorPicker = true): self
    {
        $this->colorPicker = $colorPicker;

        return $this;
    }

    /**
     * Number of columns (used for `textarea`, `radioTable` and `tableWizard` fields).
     */
    public ?int $cols {
        get => $this->__get('cols');
        set {
            $this->__set('cols', $value);
        }
    }

    public function cols(int $cols): self
    {
        $this->cols = $cols;

        return $this;
    }

    /**
     * The choice of this field will not be stored as serialized string but rather as given delimiter-separated list.
     *
     * Example:
     *
     *      'eval' => ['csv' => ',']
     */
    public ?string $csv {
        get => $this->__get('csv');
        set {
            $this->__set('csv', $value);
        }
    }

    public function csv(string $csv = ','): self
    {
        $this->csv = $csv;

        return $this;
    }

    /**
     * Custom regular expression to be used when using `'rgxp' => 'custom'`
     */
    public ?string $customRgxp {
        get => $this->__get('customRgxp');
        set {
            $this->__set('customRgxp', $value);
        }
    }

    public function customRgxp(string $customRgxp, ?string $errorMessage = null): self
    {
        $this->customRgxp = $customRgxp;
        $this->errorMsg = $errorMessage;

        return $this;
    }

    /**
     * Custom error message to be used when using `'rgxp' => 'custom'`
     */
    public ?string $errorMsg {
        get => $this->__get('errorMsg');
        set {
            $this->__set('errorMsg', $value);
        }
    }

    public function errorMsg(string $errorMsg): self
    {
        $this->errorMsg = $errorMsg;

        return $this;
    }

    /**
     * Use own template for this input field
     *
     *      'customTpl' => 'template-file-name'
     */
    public ?string $customTpl {
        get => $this->__get('customTpl');
        set {
            $this->__set('customTpl', $value);
        }
    }

    public function customTpl(string $customTpl): self
    {
        $this->customTpl = $customTpl;

        return $this;
    }

    /**
     * If true, the current field will have a MooTools-DatePicker.
     */
    public ?bool $datePicker {
        get => $this->__get('datepicker');
        set {
            $this->__set('datepicker', $value);
        }
    }

    public function datePicker(bool $datePicker = true): self
    {
        $this->datePicker = $datePicker;

        return $this;
    }

    /**
     * If true, the general purpose picker will be shown. Allows to pick different records from the system and return them as an insert tag.
     */
    public ?bool $dcaPicker {
        get => $this->__get('dcaPicker');
        set {
            $this->__set('dcaPicker', $value);
        }
    }

    public function dcaPicker(bool $dcaPicker = true): self
    {
        $this->dcaPicker = $dcaPicker;

        return $this;
    }

    /**
     * If true, HTML entities will be decoded. Note that HTML entities are always decoded if allowHtml is true.
     */
    public ?bool $decodeEntities {
        get => $this->__get('decodeEntities');
        set {
            $this->__set('decodeEntities', $value);
        }
    }

    public function decodeEntities(bool $decodeEntities = true): self
    {
        $this->decodeEntities = $decodeEntities;

        return $this;
    }

    /**
     * Disables the field (not supported by all field types).
     */
    public ?bool $disabled {
        get => $this->__get('disabled');
        set {
            $this->__set('disabled', $value);
        }
    }

    public function disabled(bool $disabled = true): self
    {
        $this->disabled = $disabled;

        return $this;
    }

    /**
     * If true, the current field will not be duplicated if the record is duplicated.
     */
    public ?bool $doNotCopy {
        get => $this->__get('doNotCopy');
        set {
            $this->__set('doNotCopy', $value);
        }
    }

    public function doNotCopy(bool $doNotCopy = true): self
    {
        $this->doNotCopy = $doNotCopy;

        return $this;
    }

    /**
     * If true, the field will not be saved if it is empty.
     */
    public ?bool $doNotSaveEmpty {
        get => $this->__get('doNotSaveEmpty');
        set {
            $this->__set('doNotSaveEmpty', $value);
        }
    }

    public function doNotSaveEmpty(bool $doNotSaveEmpty = true): self
    {
        $this->doNotSaveEmpty = $doNotSaveEmpty;

        return $this;
    }

    /**
     * If true, the current field will not be shown in “edit all” or “show details” mode.
     */
    public ?bool $doNotShow {
        get => $this->__get('doNotShow');
        set {
            $this->__set('doNotShow', $value);
        }
    }

    public function doNotShow(bool $doNotShow = true): self
    {
        $this->doNotShow = $doNotShow;

        return $this;
    }

    /**
     * If true, the whitespace of the input of this field will not be trimmed before saving.
     */
    public ?bool $doNotTrim {
        get => $this->__get('doNotTrim');
        set {
            $this->__set('doNotTrim', $value);
        }
    }

    public function doNotTrim(bool $doNotTrim = true): self
    {
        $this->doNotTrim = $doNotTrim;

        return $this;
    }

    /**
     * If true, the field value will be stored encrypted.
     */
    public ?bool $encrypt {
        get => $this->__get('encrypt');
        set {
            $this->__set('encrypt', $value);
        }
    }

    public function encrypt(bool $encrypt = true): self
    {
        $this->encrypt = $encrypt;

        return $this;
    }

    /**
     * Limits the file tree to certain file types (comma separated list). Applies to file trees only.
     */
    public ?string $extensions {
        get => $this->__get('extensions');
        set {
            $this->__set('extensions', $value);
        }
    }

    public function extensions(string $extensions): self
    {
        $this->extensions = $extensions;

        return $this;
    }

    /**
     * If true, the field can only be assigned once per table.
     */
    public ?bool $fallback {
        get => $this->__get('fallback');
        set {
            $this->__set('fallback', $value);
        }
    }

    public function fallback(bool $fallback = true): self
    {
        $this->fallback = $fallback;

        return $this;
    }

    public ?bool $feEditable {
        get => $this->__get('feEditable');
        set {
            $this->__set('feEditable', $value);
        }
    }

    public function feEditable(bool $feEditable = true, ?string $feGroup = null): self
    {
        $this->feEditable = $feEditable;
        $this->feGroup = $feGroup;

        return $this;
    }

    public ?string $feGroup {
        get => $this->__get('feGroup');
        set {
            $this->__set('feGroup', $value);
        }
    }

    public function feGroup(string $feGroup): self
    {
        $this->feGroup = $feGroup;

        return $this;
    }

    public ?string $fieldType {
        get => $this->__get('fieldType');
        set {
            $this->__set('fieldType', $value);
        }
    }

    public function fieldType(string $fieldType): self
    {
        $this->fieldType = $fieldType;

        return $this;
    }

    public ?bool $files {
        get => $this->__get('files');
        set {
            $this->__set('files', $value);
        }
    }

    public function files(bool $files = true): self
    {
        $this->files = $files;

        return $this;
    }

    public ?bool $filesOnly {
        get => $this->__get('filesOnly');
        set {
            $this->__set('filesOnly', $value);
        }
    }

    public function filesOnly(bool $filesOnly = true): self
    {
        $this->filesOnly = $filesOnly;

        return $this;
    }

    public ?bool $findInSet {
        get => $this->__get('findInSet');
        set {
            $this->__set('findInSet', $value);
        }
    }

    public function findInSet(bool $findInSet = true): self
    {
        $this->findInSet = $findInSet;

        return $this;
    }

    public ?bool $helpWizard {
        get => $this->__get('helpwizard');
        set {
            $this->__set('helpwizard', $value);
        }
    }

    public function helpWizard(bool $helpWizard = true): self
    {
        $this->helpWizard = $helpWizard;

        return $this;
    }

    public ?bool $hideInput {
        get => $this->__get('hideInput');
        set {
            $this->__set('hideInput', $value);
        }
    }

    public function hideInput(bool $hideInput = true): self
    {
        $this->hideInput = $hideInput;

        return $this;
    }

    public ?bool $includeBlankOption {
        get => $this->__get('includeBlankOption');
        set {
            $this->__set('includeBlankOption', $value);
        }
    }

    public function includeBlankOption(bool $includeBlankOption = true): self
    {
        $this->includeBlankOption = $includeBlankOption;

        return $this;
    }

    public ?bool $isAssociative {
        get => $this->__get('isAssociative');
        set {
            $this->__set('isAssociative', $value);
        }
    }

    public function isAssociative(bool $isAssociative = true): self
    {
        $this->isAssociative = $isAssociative;

        return $this;
    }

    public ?bool $isBoolean {
        get => $this->__get('isBoolean');
        set {
            $this->__set('isBoolean', $value);
        }
    }

    public function isBoolean(bool $isBoolean = true): self
    {
        $this->isBoolean = $isBoolean;

        return $this;
    }

    public ?bool $isGallery {
        get => $this->__get('isGallery');
        set {
            $this->__set('isGallery', $value);
        }
    }

    public function isGallery(bool $isGallery = true): self
    {
        $this->isGallery = $isGallery;

        return $this;
    }

    public ?bool $isHexColor {
        get => $this->__get('isHexColor');
        set {
            $this->__set('isHexColor', $value);
        }
    }

    public function isHexColor(bool $isHexColor = true): self
    {
        $this->isHexColor = $isHexColor;

        return $this;
    }

    public ?bool $isSortable {
        get => $this->__get('isSortable');
        set {
            $this->__set('isSortable', $value);
        }
    }

    public function isSortable(bool $isSortable = true): self
    {
        $this->isSortable = $isSortable;

        return $this;
    }

    public ?bool $mandatory {
        get => $this->__get('mandatory');
        set {
            $this->__set('mandatory', $value);
        }
    }

    public function mandatory(bool $mandatory = true): self
    {
        $this->mandatory = $mandatory;

        return $this;
    }

    public ?int $maxLength {
        get => $this->__get('maxlength');
        set {
            $this->__set('maxlength', $value);
        }
    }

    public function maxLength(int $maxLength, ?int $minLength = null): self
    {
        $this->maxLength = $maxLength;

        if ($minLength) {
            $this->minLength = \min($maxLength, $minLength);
        }

        return $this;
    }

    public ?int $maxVal {
        get => $this->__get('maxval');
        set {
            $this->__set('maxval', $value);
        }
    }

    public function maxVal(int $maxVal, ?int $minVal = null): self
    {
        $this->maxVal = $maxVal;

        if ($minVal) {
            $this->minVal = \min($maxVal, $minVal);
        }

        return $this;
    }

    public ?array $metaFields {
        get => $this->__get('metaFields');
        set {
            $this->__set('metaFields', $value);
        }
    }

    public function metaFields(array $metaFields): self
    {
        $this->metaFields = $metaFields;

        return $this;
    }

    public ?int $minLength {
        get => $this->__get('minlength');
        set {
            $this->__set('minlength', $value);
        }
    }

    public function minLength(int $minLength, ?int $maxLength = null): self
    {
        $this->minLength = $minLength;

        if ($maxLength) {
            $this->maxLength = \max($minLength, $maxLength);
        }

        return $this;
    }

    public ?int $minVal {
        get => $this->__get('minval');
        set {
            $this->__set('minval', $value);
        }
    }

    public function minVal(int $minVal, ?int $maxVal = null): self
    {
        $this->minVal = $minVal;

        if ($maxVal) {
            $this->maxVal = \max($this->minVal, $maxVal);
        }

        return $this;
    }

    public ?bool $multiple {
        get => $this->__get('multiple');
        set {
            $this->__set('multiple', $value);
        }
    }

    public function multiple(bool $multiple = true): self
    {
        $this->multiple = $multiple;

        return $this;
    }

    public ?bool $noSpace {
        get => $this->__get('nospace');
        set {
            $this->__set('nospace', $value);
        }
    }

    public function noSpace(bool $noSpace = true): self
    {
        $this->noSpace = $noSpace;

        return $this;
    }

    public ?string $orderField {
        get => $this->__get('orderField');
        set {
            $this->__set('orderField', $value);
        }
    }

    public function orderField(string $orderField): self
    {
        $this->orderField = $orderField;

        return $this;
    }

    public ?string $path {
        get => $this->__get('path');
        set {
            $this->__set('path', $value);
        }
    }

    public function path(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public ?string $placeholder {
        get => $this->__get('placeholder');
        set {
            $this->__set('placeholder', $value);
        }
    }

    public function placeholder(string $placeholder): self
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    public ?bool $preserveTags {
        get => $this->__get('preserveTags');
        set {
            $this->__set('preserveTags', $value);
        }
    }

    public function preserveTags(bool $preserveTags = true): self
    {
        $this->preserveTags = $preserveTags;

        return $this;
    }

    public ?bool $readonly {
        get => $this->__get('readonly');
        set {
            $this->__set('readonly', $value);
        }
    }

    public function readonly(bool $readonly = true): self
    {
        $this->readonly = $readonly;

        return $this;
    }

    public ?string $rgxp {
        get => $this->__get('rgxp');
        set {
            $this->__set('rgxp', $value);
        }
    }

    public function rgxp(string $rgxp): self
    {
        $this->rgxp = $rgxp;

        return $this;
    }

    public ?int $rows {
        get => $this->__get('rows');
        set {
            $this->__set('rows', $value);
        }
    }

    public function rows(int $rows): self
    {
        $this->rows = $rows;

        return $this;
    }

    public ?string $rte {
        get => $this->__get('rte');
        set {
            $this->__set('rte', $value);
        }
    }

    public function rte(string $rte): self
    {
        $this->rte = $rte;

        return $this;
    }

    public ?int $size {
        get => $this->__get('size');
        set {
            $this->__set('size', $value);
        }
    }

    public function size(int $size): self
    {
        $this->size = $size;

        return $this;
    }

    public ?bool $spaceToUnderscore {
        get => $this->__get('spaceToUnderscore');
        set {
            $this->__set('spaceToUnderscore', $value);
        }
    }

    public function spaceToUnderscore(bool $spaceToUnderscore = true): self
    {
        $this->spaceToUnderscore = $spaceToUnderscore;

        return $this;
    }

    public ?string $style {
        get => $this->__get('style');
        set {
            $this->__set('style', $value);
        }
    }

    public function style(string $style): self
    {
        $this->style = $style;

        return $this;
    }

    public ?bool $submitOnChange {
        get => $this->__get('submitOnChange');
        set {
            $this->__set('submitOnChange', $value);
        }
    }

    public function submitOnChange(bool $submitOnChange = true): self
    {
        $this->submitOnChange = $submitOnChange;

        return $this;
    }

    public ?string $class {
        get => $this->__get('tl_class');
        set {
            $this->__set('tl_class', $value);
        }
    }

    public function class(string $class): self
    {
        $this->class = $class;

        return $this;
    }

    public ?bool $trailingSlash {
        get => $this->__get('trailingSlash');
        set {
            $this->__set('trailingSlash', $value);
        }
    }

    public function trailingSlash(bool $trailingSlash = true): self
    {
        $this->trailingSlash = $trailingSlash;

        return $this;
    }

    public ?bool $unique {
        get => $this->__get('unique');
        set {
            $this->__set('unique', $value);
        }
    }

    public function unique(bool $unique = true): self
    {
        $this->unique = $unique;

        return $this;
    }

    public ?string $uploadFolder {
        get => $this->__get('uploadFolder');
        set {
            $this->__set('uploadFolder', $value);
        }
    }

    public function uploadFolder(string $uploadFolder): self
    {
        $this->uploadFolder = $uploadFolder;

        return $this;
    }

    public ?bool $useRawRequestData {
        get => $this->__get('useRawRequestData');
        set {
            $this->__set('useRawRequestData', $value);
        }
    }

    public function useRawRequestData(bool $useRawRequestData = true): self
    {
        $this->useRawRequestData = $useRawRequestData;

        return $this;
    }

    public ?bool $versionize {
        get => $this->__get('versionize');
        set {
            $this->__set('versionize', $value);
        }
    }

    public function versionize(bool $versionize = true): self
    {
        $this->versionize = $versionize;

        return $this;
    }


    public function __construct(string $table, string $field)
    {
        $this->_table = $table;
        $this->_field = $field;
    }

    public function __get(string $name): mixed
    {
        return $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_field]['eval'][$name] ?? null;
    }

    public function __set(string $name, mixed $value): void
    {
        $GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_field]['eval'][$name] = $value;
    }

    public function __isset(string $name): bool
    {
        return isset($GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_field]['eval'][$name]);
    }

    public function __unset(string $name): void
    {
        unset($GLOBALS['TL_DCA'][$this->_table]['fields'][$this->_field]['eval'][$name]);
    }

}
