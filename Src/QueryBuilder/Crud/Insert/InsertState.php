<?php declare(strict_types=1);
namespace Noga\QueryBuilder\Crud\Insert;

final class InsertState
{
    public function __construct(
        public ?string $type = null,
        public ?string $driver = null,
        public ?string $table = null,
        public array $columns = [],
        public array $values = [],
        public array $bind = [],
        public array $params = [],
        public array $except = []
    ) {}

    public function toArray():array
    {
        return [
            "TYPE"    => $this->type,
            "DRIVER"  => $this->driver,
            "TABLE"   => $this->table,
            "COLUMNS" => $this->columns,
            "VALUES"  => $this->values,
            "BIND"    => $this->bind,
            "PARAMS"  => $this->params,
            "EXCEPT"  => $this->except
        ];
    }
}
