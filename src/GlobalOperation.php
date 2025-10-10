<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor;

final class GlobalOperation
{
    use HasCustomProperties;

    public mixed $button_callback {
        set {
            if (\is_callable($value)) {
                $this->button_callback = $value;
            }
            throw new \InvalidArgumentException('The callback must be callable.');
        }
    }

    public function __construct(
        public ?string $label = null,
        public ?string $href = null,
        public ?string $icon = null,
        public ?string $class = null,
        public ?string $attributes = null,
        ?callable $button_callback = null,
        public ?string $route = null
    )
    {
        $this->button_callback = $button_callback;
    }

    protected function &getDcaPath(): array
    {
        // TODO: Implement getDcaPath() method.
    }
}
