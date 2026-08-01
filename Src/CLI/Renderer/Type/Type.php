<?php
declare(strict_types=1);

namespace Noga\CLI\Renderer\Type;

abstract class Type{
    /**
     * @return static|string|array<mixed>|int|void
     */
    abstract protected function handle();

    abstract public function render();

    /**
     * Summary of values
     * @var string|array<mixed>|int
     */
    protected mixed $values;
}