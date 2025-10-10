<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor;

/**
 * @see https://docs.contao.org/dev/reference/dca/config/#sql-configuration
 */
final readonly class ConfigCallbacks
{

    public CallbackBag $create;
    public CallbackBag $load;
    public CallbackBag $beforeSubmit;
    public CallbackBag $submit;
    public CallbackBag $delete;
    public CallbackBag $cut;
    public CallbackBag $copy;
    public CallbackBag $undo;
    public CallbackBag $version;
    public CallbackBag $restore;
    public CallbackBag $restoreVersion;


    public function __construct(private readonly string $table)
    {
        $this->create = new CallbackBag($this->getReference('oncreate_callback'));
        $this->load = new CallbackBag($this->getReference('onload_callback'));
        $this->beforeSubmit = new CallbackBag($this->getReference('onbefore_submit_callback'));
        $this->submit = new CallbackBag($this->getReference('onsubmit_callback'));
        $this->delete = new CallbackBag($this->getReference('ondelete_callback'));
        $this->cut = new CallbackBag($this->getReference('oncut_callback'));
        $this->copy = new CallbackBag($this->getReference('oncopy_callback'));
        $this->undo = new CallbackBag($this->getReference('onundo_callback'));
        $this->version = new CallbackBag($this->getReference('onversion_callback'));
        $this->restore = new CallbackBag($this->getReference('onrestore_callback'));
        $this->restoreVersion = new CallbackBag($this->getReference('onrestoreVersion_callback'));
    }

    private function &getReference(string $name): array
    {
        // make sure that the array exists because we can only return valid variable as reference
        if (!isset($GLOBALS['TL_DCA'][$this->table]['config'][$name])) {
            $GLOBALS['TL_DCA'][$this->table]['config'][$name] = [];
        }

        return $GLOBALS['TL_DCA'][$this->table]['config'][$name];
    }

}
