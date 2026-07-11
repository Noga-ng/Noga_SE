<?php declare (strict_types = 1);
namespace Noga\Traits;

use Noga\Db\Connection\Connect;
use Noga\Db\Db;
use PDOStatement;

trait DbTrait
{
    protected ?string $driver = null;
    protected PDOStatement $stmt;
    private ?Connect $connect = null;

    /**
     * Summary of conn
     * @return Connect|null
     */
    private function connect(?string $driver = null):?Connect{
        if($this->connect === null){
            $this->connect = Connect::driver($driver);
        }

        return $this->connect;
    }

    /**
     * Summary of driver
     * @param ?string $driver
     * @return static
     */
    public function driver(?string $driver):static
    {
      $clone = clone $this;
      $clone->connect($driver);
      return $clone;
    }

    /**
     * Summary of database
     * @param mixed $database
     * @return static
     */
    public function database(?string $database = null):static
    {
      $clone = clone $this;
      $clone->connect()->database($database);
      return $clone;
    }

    /**
     * Summary of db
     * @return Db|null
     */
    public function db(): ?Db
    {
       return $this->connect()->conn();
    }


    public function getDriver(): string
    {
      return $this->connect()->getDriver();
    }

    public function getDb():?string{
      return $this->connect()->conn()->getDatabase();
    }

     /**
     * Summary of transaction
     * @param callable $callback
     * @return mixed
     */
    public function transaction(callable | self $callback):mixed
    {
       return $this->db()->toTransaction($callback,$this);
    }

}

