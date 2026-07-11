<?php declare(strict_types=1);
namespace Noga\Db\Connection;


use Noga\Db\Db;
use Noga\Db\Mysql;
use Noga\Db\Pgsql;
use Noga\Db\Sqlite;
use Noga\Noga;
use RuntimeException;

class Connect{

    /**
     * Summary of driver
     * @var string|null
     */
    public ?string $driver = null;

    /**
     * Summary of DRIVER_ACCEPT
     * @var array
     */
    private const DRIVER_ACCEPT = ['mysql','pgsql','sqlite'];

    /**
     * Summary of database
     * @var string
     */
    private ?string $database = null;
    /**
     * Summary of conn
     * @var Db|null
     */
    private ?Db $conn = null;

    public function __construct(?string $driver = null)
    {
        $this->driver = $driver ??= Noga::get('driver');

        if(!\in_array($this->driver,self::DRIVER_ACCEPT)){
            throw new RuntimeException("{$this->driver} is not supported");
        }

    }

    /**
     * Summary of driver
     * @param string|null $driver
     * @return static
     */
    public static function driver(?string $driver = null):static{    
        return new static($driver);
    }

    /**
     * Summary of database
     * @param ?string $database
     * @return static
     */
    public function database(?string $database):static{
        $this->database = $database;
        return $this;
    }

    public function getDriver():?string{
        return $this->driver;
    }

    public function getDb():?string{
        return $this->database;
    }

   /**
    * Summary of conn
    * @return Db|null
    */
   public function conn(): ?Db
    { 
        if ($this->conn === null) {
            $this->conn = match($this->driver){
                'mysql'     => new Mysql($this->getDb()),
                'pgsql'     => new Pgsql($this->getDb()),
                'sqlite'    => new Sqlite($this->getDb()),
                default     => new Mysql($this->getDb())
            };
        }

        return $this->conn;
    }
}