<?php declare(strict_types=1);
namespace Noga\Db;

use PDO;
use Noga\Db\Db;
use Noga\Noga;

class Sqlite extends Db
{
    public function __construct(protected ?string $database = null)
    {
        $this->driver   = 'sqlite';
        $this->database = ($database === null) ? $database : Noga::get('base_path')."/{$_ENV['Lite_db']}";
        if(isset($_ENV['Lite_option']) && !empty($_ENV['Lite_option']))  $this->options = $_ENV['Lite_option'];
        $this->set_session = "PRAGMA foreign_keys = ON";
    }

    protected function getDsn(): string
    {
        return "sqlite:{$this->database} ";
    }

    protected function getUsername(): string { return ''; }
    protected function getPassword(): string { return ''; }

    protected function getOptions(): array
    {
        return $this->options;
    }
}
