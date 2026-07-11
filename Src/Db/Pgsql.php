<?php declare(strict_types=1);
namespace Noga\Db;

use Noga\Db\Db;

final class Pgsql extends Db
{
    public function __construct(?string $database = null)
    {
        $this->driver   = $_ENV['PG_DRIVER'] ?? 'pgsql';
        $this->host     = $_ENV['PG_HOST'] ?? 'localhost';
        $this->port     = $_ENV['PG_PORT'] ?: 5432;
        $this->database = ($database !== null) ? $database : $_ENV['PG_DATABASE'];
        $this->charset  = $_ENV['PG_CHARSET'] ?? 'UTF8';
        $this->username = $_ENV['PG_USERSNAME'] ?? 'postgres';
        $this->password = $_ENV['PG_PASSWORD'] ?? '';
        $this->options = $_ENV['PG_OPTIONS'] ?? $this->options;
        // PostgreSQL-safe session
        $this->set_session = "SET client_encoding = 'UTF8'";
    }

    protected function getDsn(): string
    {
        return \sprintf(
            "%s:host=%s;port=%d;dbname=%s",
            $this->driver,
            $this->host,
            $this->port,
            $this->database
        );
    }

    protected function getUsername(): string
    {
        return $this->username;
    }

    protected function getPassword(): string
    {
        return $this->password;
    }

    protected function getOptions(): array
    {
        return $this->options;
    }

    
}
