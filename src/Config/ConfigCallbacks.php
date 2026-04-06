<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor\Config;

use Tastaturberuf\ContaoDataContainerAccessor\CallbackBag;

/**
 * @see https://docs.contao.org/dev/reference/dca/config/#sql-configuration
 */
final class ConfigCallbacks
{
    public CallbackBag $create {
        get => $this->create ?? new CallbackBag($this->getReference('oncreate_callback'));
    }
    public CallbackBag $load {
        get => $this->load ?? new CallbackBag($this->getReference('onload_callback'));
    }
    public CallbackBag $beforeSubmit {
        get => $this->beforeSubmit ?? new CallbackBag($this->getReference('onbeforesubmit_callback'));
    }
    public CallbackBag $submit {
        get => $this->submit ?? new CallbackBag($this->getReference('onsubmit_callback'));
    }
    public CallbackBag $delete {
        get => $this->delete ?? new CallbackBag($this->getReference('ondelete_callback'));
    }
    public CallbackBag $cut {
        get => $this->cut ?? new CallbackBag($this->getReference('oncut_callback'));
    }
    public CallbackBag $copy {
        get => $this->copy ?? new CallbackBag($this->getReference('oncopy_callback'));
    }
    public CallbackBag $undo {
        get => $this->undo ?? new CallbackBag($this->getReference('onundo_callback'));
    }
    public CallbackBag $version {
        get => $this->version ?? new CallbackBag($this->getReference('onversion_callback'));
    }
    public CallbackBag $restore {
        get => $this->restore ?? new CallbackBag($this->getReference('onrestore_callback'));
    }
    public CallbackBag $restoreVersion {
        get => $this->restoreVersion ?? new CallbackBag($this->getReference('onrestore_version_callback'));
    }

    public CallbackBag $palette {
        get => $this->palette ?? new CallbackBag($this->getReference('onpalette_callback'));
    }

    public function __construct(
        private readonly string $table,
    ) {}

    private function &getReference(string $name): array
    {
        // make sure that the array exists because we can only return valid variable as reference
        $GLOBALS['TL_DCA'][$this->table]['config'][$name] ??= [];

        return $GLOBALS['TL_DCA'][$this->table]['config'][$name];
    }
}
