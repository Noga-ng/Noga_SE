<?php declare(strict_types=1);

namespace Noga\Immutability;

use Noga\Contracts\Immutability\Immutable;
use Override;

final class Immutability implements Immutable{
    #[Override]
    public function copy(): static
    {
        $clone = clone $this;
        return $clone;
    }

    #[Override]
    public function mutate(callable $callback): static
    {
        $clone = clone $this;
        
        return $callback($clone);
    }
}
