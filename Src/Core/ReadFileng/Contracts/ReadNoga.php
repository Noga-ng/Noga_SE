<?php
namespace Noga\Core\ReadFileng\Contracts;

interface ReadNoga{

    /**
     * Summary of get
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed;

    /**
     * Summary of has
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * Summary of all
     * @return array
     */
    public function all(): array;
}