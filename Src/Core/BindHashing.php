<?php declare(strict_types=1);
namespace Noga\Core;

use Noga\Contracts\Bind\BindingInt;

final class BindHashing implements BindingInt{
    private string $bindParams = "";

    public function __construct(private string $prefix,private string $columns,private int $bytelength = 4)
    {
        $col = str_replace(['.', '-'], '_', $this->columns);
        $hash = \bin2hex(\random_bytes($bytelength));
        $this->bindParams = ":{$this->prefix}_{$hash}_{$col}";
    }
    
    public static function hash(string $prefix,string $columns,int $bytelength = 4):string{
      $instance = new static($prefix,$columns);
      return $instance->bindParams;
    }
}