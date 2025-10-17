<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoDataContainerAccessor;

use function array_splice;
use function count;

final class CallbackBag
{

    public function __construct(private array &$path)
    {
    }

    public function all(): array
    {
        return $this->path;
    }

    public function add(callable $callback, ?int $position = null): self
    {
        $position ??= count($this->path);

        array_splice($this->path, $position, 0, $callback);

        return $this;
    }

    public function get(int $position): ?callable
    {
        return $this->path[$position] ?? null;
    }

    public function remove(int $position): self
    {
        array_splice($this->path, $position, 1);

        return $this;
    }

}
