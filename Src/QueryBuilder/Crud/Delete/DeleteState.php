<?php declare(strict_types=1);
namespace Noga\QueryBuilder\Crud\Delete;

class DeleteState
{

    public function __construct(
        public ?string $type = null,
        public ?string $driver = null,
        public ?string $table = null,
        public array $condition = [],
        public array $params = [],
        public ?int $limit = null
    ) {}

    public function toArray(): array
    {
        return [
            "TYPE"       => $this->type,
            "DRIVER"     => $this->driver,
            "TABLE"      => $this->table,
            "CONDITIONS" => $this->condition,
            "PARAMS"     => $this->params,
            "LIMIT"      => $this->limit,
        ];
    }
}
