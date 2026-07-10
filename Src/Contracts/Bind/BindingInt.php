<?php
namespace Noga\Contracts\Bind;

interface BindingInt{
    /**
     * Summary of hash
     * @param string $prefix
     * @param string $columns
     * @return string
     */
    public static function hash(string $prefix,string $columns):string;
}