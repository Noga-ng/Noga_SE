<?php declare(strict_types=1);
namespace Noga\Db;

use Noga\Db\Db;

class Pgsql extends Db
{
    public function __construct(protected string $database = '')
    {
        $this->driver   = $_ENV['PG_DRIVER'] ?? 'pgsql';
        $this->host     = $_ENV['PG_HOST'] ?? 'localhost';
        $this->port     = $_ENV['PG_PORT'] ?: 5432;
        $this->database = $this->database ?: $_ENV['PG_DATABASE'];
        $this->charset  = $_ENV['PG_CHARSET'] ?? 'UTF8';
        // PostgreSQL-safe session
        $this->set_session = "SET client_encoding = 'UTF8'";
    }

    protected function getDsn(): string
    {
        return sprintf(
            "%s:host=%s;port=%d;dbname=%s",
            $this->driver,
            $this->host,
            $this->port,
            $this->database
        );
    }

    protected function getUsername(): string
    {
        return $_ENV['PG_USERNAME'] ?? 'postgres';
    }

    protected function getPassword(): string
    {
        return $_ENV['PG_PASSWORD'] ?? '';
    }

    protected function getOptions(): array
    {
        return $_ENV['PG_OPTIONS'] ?: $this->options;
    }

    
}
