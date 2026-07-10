<?php declare(strict_types=1);
namespace Noga\QueryBuilder\Crud\Delete;

final class DeleteCompiler
{
    private string $sql = "";
    public function __construct(public DeleteState $state)
    {
        $conditions = implode(' AND ', $this->state->condition);
        $this->sql  = " DELETE FROM {$this->state->table} ";
        if (empty($this->state->condition)) {
            throw new \RuntimeException("Cannot use delete if conditions is empty ");
        }

        $this->sql .= " WHERE {$conditions} ";
        if ($this->state->limit !== null) {
            $this->sql .= " LIMIT {$this->state->limit} ";
        }

    }

    public static function toSql(DeleteState $state): string
    {
        $instance = new static($state);
        return $instance->sql;
    }
}
