<?php
declare(strict_types=1);
namespace Noga\Contracts\Immutability;

interface Immutable{
    /**
     * Summary of copy
     * @return static
     */
    public function copy():static;

    /**
     * Summary of mutate
     * @param callable $callback
     * @return static
     */
    public function mutate(callable $callback):static;

    

}