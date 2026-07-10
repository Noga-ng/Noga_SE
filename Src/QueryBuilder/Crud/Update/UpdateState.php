<?php
namespace Noga\QueryBuilder\Crud\Update;

final class UpdateState{
       public function __construct(
        public ?string $type = null,
        public ?string $driver = null,
        public ?string $table = null,
        public array $set = [],
        public array $conditions = [],
        public array $params = [],
    ){}

    public function toArray():array{
        return [
            "TYPE"=>$this->type,
            "DRIVER"=>$this->driver,
            "TABLE"=>$this->table,
            "SET"=>$this->set,
            "CONDITIONS"=>$this->conditions,
            "params"=>$this->params
        ];
    }
}