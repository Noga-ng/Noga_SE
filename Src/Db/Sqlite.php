<?php declare(strict_types=1);
namespace Noga\Db;

use PDO;
use Noga\Db\Db;

class Sqlite extends Db
{
    public function __construct(protected string $database = '')
    {
        $this->driver   = 'sqlite';
        $this->database = !empty($database) ? $database : __DIR__."/{$_ENV['Lite_db']}";

        $this->set_session = "PRAGMA foreign_keys = ON";
    }

    protected function getDsn(): string
    {
        return "sqlite:" . $this->database;
    }

    protected function getUsername(): string { return ''; }
    protected function getPassword(): string { return ''; }

    protected function getOptions(): array
    {
        return $_ENV['Lite_options'] ?: [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
    }
}
