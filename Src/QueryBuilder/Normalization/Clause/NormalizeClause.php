<?php
namespace Noga\QueryBuilder\Normalization\Clause;

class NormalizeClause{

    public function __construct(
        private array $clause = [],
        private string $type = ""
    ){}

    
}