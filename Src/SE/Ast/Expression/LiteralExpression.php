<?php

declare(strict_types=1);

namespace Noga\SE\Ast\Expression;

use Noga\SE\Enum\LiteralType;

final class LiteralExpression extends Expression
{
    public function __construct(
        public readonly mixed $value,
        public readonly LiteralType $type,
    ) {
    }

    public static function integer(int $value): LiteralExpression
    {
        return new static($value, LiteralType::INTEGER);
    }

    public static function float(float $value): self
    {
        return new self($value, LiteralType::FLOAT);
    }

    public static function string(string $value): self
    {
        return new self($value, LiteralType::STRING);
    }

    public static function boolean(bool $value): self
    {
        return new self($value, LiteralType::BOOLEAN);
    }

    public static function null(): self
    {
        return new self(null, LiteralType::NULL);
    }
}