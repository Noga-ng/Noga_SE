<?php declare (strict_types = 1);
namespace Noga\Traits;

use Noga\Core\CacheManager;
use Noga\Db\Db;
use Noga\Db\Mysql;
use Noga\Db\Pgsql;
use Noga\Db\Sqlite;
use Noga\Noga;
use PDOStatement;
use RuntimeException;

trait DbTrait
{
    protected string $driver = "";
    protected PDOStatement $stmt;
    protected array $driverList = [
        "mysql",
        "sqlite",
        "pgsql",
    ];

    /**
     * Summary of db
     * @var Db
     */
    private ?Db $db = null;

    /**
     * Summary of driver
     * @param string $driver
     * @param string $database
     * @return static
     */
    public function driver(string $driver, string $database = ""): static
    {
        $clone         = clone $this;
        $clone->driver = $driver;

        if (! \in_array($driver, $this->driverList)) {
            throw new RuntimeException("error your driver {$driver} is not supported ! ");
        }

        $clone->driver = strtolower($clone->driver);

        if ($clone->driver === "mysql") {
            $clone->db = new Mysql($database);
            return $clone;

        } else if ($clone->driver === "sqlite") {

            $clone->db = new Sqlite($database);
            return $clone;
        } else if ($clone->driver === "pgsql") {
            $clone->db = new Pgsql($database);
        }

        return $clone;
    }

    /**
     * Summary of db
     * @return Db|null
     */
    private function db(): ?Db
    {
        if ($this->db === null) {
          $this->driver = Noga::get('driver');

            $this->db = match($this->driver){
                'mysql'=> new Mysql(),
                'pgsql' => new Pgsql(),
                'sqlite' => new Sqlite(),
                default => new Mysql()
            };
        }

        return $this->db;
    }


}
