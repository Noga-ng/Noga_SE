<?php declare(strict_types=1);
namespace Noga\Db;

use Noga\Db\Db;
class Mysql extends Db{

    public function __construct(protected ?string $database = null)
    {
            $this->driver = $_ENV['MY_DRIVER'] ?? 'mysql';
            $this->host = $_ENV['MY_HOST'] ?? '127.0.0.1';
            $this->port = $_ENV['DB_PORT'] ?: 3306;
            $this->database = $this->database ?: $_ENV['MY_DATABASE'];
            $this->charset = $_ENV['MY_CHARSET'] ?? 'utf8mb4';
            $this->username = $_ENV['MY_USERSNAME'] ?? 'root';
            $this->password = $_ENV['MY_PASSWORD'] ?? "";
            $this->options = $_ENV['MY_OPTIONS'] ?? $this->options;
            $this->set_session = $_ENV['MY_SET_SESSION'] ?? "SET SESSION sql_mode=''";
    }

    protected function getDsn(): string
    {
        return \sprintf(
            "%s:host=%s;port=%d;dbname=%s;charset=%s",
            $this->driver,
            $this->host,
            $this->port,
            $this->database,
            $this->charset
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


    /**
     * Summary of connect
     * @return \PDO|null
     */
    public function connect():\PDO|null
    {
        return parent::connect();
    }

}