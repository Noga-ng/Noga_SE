<?php

declare(strict_types=1);

namespace Noga\SE\Ast\Identifier;

final class QualifiedIdentifier extends Identifier
{
    /**
     * @param string[] $parts
     */
    public function __construct(
        public readonly array $parts
    ) {
    }

    public static function of(string ...$parts): self
    {
        return new self($parts);
    }

    public function count(): int
    {
        return \count($this->parts);
    }

    public function last(): string
    {
        return $this->parts[$this->count() - 1];
    }
}