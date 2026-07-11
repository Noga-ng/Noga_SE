<?php

namespace Noga\Db;

use Generator;
use Noga\QueryBuilder\Select\Select;
use PDO;
use PDOException;
use PDOStatement;
use RuntimeException;
use Throwable;

/**
 * Summary of Db
 */
abstract class Db implements \Noga\Contracts\Db\Db
{
    private ?PDO $pdo = null;
    protected array $instanceDb = [];
    private string $key = "";
    protected string $host;
    protected ?int $port;
    protected string $username;
    protected string $password;
    protected ?string $database = null;
    protected string $charset = "utf8mb4";
    protected string $driver;
    protected string $collation = "utf8mb4_general_ci";
    protected string $set_session = "SET SESSION sql_mode=''";
    protected array $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ];

    public function __construct()
    {
        $this->key = md5($this->getDsn());
    }

    /**
     * Summary of connect 
     * centrale connexion method that 
     * establish a connection to the database using PDO and returns the PDO instance.
     *  It checks if a connection already exists and reuses it if available, 
     * otherwise it creates a new connection using the provided configuration parameters.
     *  It also handles any exceptions that may occur during the connection process and
     *  throws a RuntimeException with an appropriate error message.
     * @throws RuntimeException
     * @return PDO|null
     */

    public function connect(): PDO|null
    {
        try {

            if (!isset($this->instanceDb[$this->key])) {

                $this->pdo = new PDO(
                    $this->getDsn(),
                    $this->getUsername(),
                    $this->getPassword(),
                    $this->getOptions()
                );

                $this->pdo->exec($this->set_session);

                $this->instanceDb[$this->key] = $this->pdo;
            }

            return $this->instanceDb[$this->key];
        } catch (PDOException $e) {
            throw new RuntimeException("error connection : " . $e->getMessage());
        }
    }

    /**
     * Summary of disconnect
     * 
     * this is a method that is responsible for closing the database connection by setting 
     * the static property $pdo to null.
     * 
     * @return null
     */
    public function disconnect()
    {
        return static::$pdo = null;
    }
    /**
     * Summary of fais
     * this method is responsible for executing a SQL query with optional parameters.
     * It prepares the SQL statement using the PDO connection, executes it with the provided parameters,
     * and returns the resulting PDOStatement object. If any exceptions occur during the execution of the query,
     * it catches the PDOException and throws a RuntimeException with an appropriate error message.
     * @param string $sql
     * @param array $params
     * @throws RuntimeException
     * @return PDOStatement
     */
    public function execute(string $sql, array $params = []): PDOStatement
    {
        try {

            $stmt = $this->connect()->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            throw new RuntimeException("{$this->driver} => Request error : " . $e->getMessage());
        }
    }
    /**
     * Summary of One
     * this method is responsible for executing a SQL query and fetching a single result.
     * It takes a SQL query as a string, an optional array of parameters for the query,
     *  and an optional fetch mode (defaulting to PDO::FETCH_OBJ).
     * The method prepares the SQL statement using the PDO connection, 
     * executes it with the provided parameters, and returns the fetched result based on the specified fetch mode. 
     * If any exceptions occur during the execution of the query, it catches the PDOException and 
     * throws a RuntimeException with an appropriate error message.
     * @param string $sql
     * @param array $params
     * @param int $fetchMode
     * @return mixed
     */
    public function one(string $sql, array $params = [], int $fetchMode = PDO::FETCH_OBJ): mixed
    {
        $stmt = $this->execute($sql, $params);
        return $stmt->fetch($fetchMode);
    }

    /**
     * Summary of All
     * this method is responsible for executing a SQL query and fetching all results.
     * It takes a SQL query as a string, an optional array of parameters for the query,
     *  and an optional fetch mode (defaulting to PDO::FETCH_OBJ).
     * The method prepares the SQL statement using the PDO connection, 
     * executes it with the provided parameters, and returns all fetched results based on the specified fetch mode.
     * If any exceptions occur during the execution of the query, 
     * it catches the PDOException and throws a RuntimeException with an appropriate error message.
     * @param string $sql
     * @param array $params
     * @param int $fetchMode
     * @return array
     */
    public function all(string $sql, array $params = [], int $fetchMode = PDO::FETCH_OBJ): array
    {

        $stmt = $this->execute($sql, $params);

        return $stmt->fetchAll($fetchMode);
    }

    /**
     * Summary of stream
     * this method is responsible for executing a SQL query and streaming the results one by one.
     * It takes a SQL query as a string, an optional array of parameters for the query, 
     * and an optional fetch mode (defaulting to PDO::FETCH_OBJ).
     * @param string $sql
     * @param array $params
     * @param int $fetchMode
     * @return Generator
     */
    public function stream(string $sql, array $params = [], int $fetchMode = PDO::FETCH_OBJ): Generator
    {
        $stmt = $this->execute($sql, $params);
        while ($row = $stmt->fetch($fetchMode)) {
            yield $row;
        }
    }

    /**
     * Summary of lastId
     * this method is responsible for retrieving the last inserted ID from the database.
     * @return bool|string
     */
    public function lastId(): string
    {
        return $this->connect()->lastInsertId();
    }

    /**
     * Summary of create
     * this method is responsible for executing a SQL query without parameters and 
     * returning the resulting PDOStatement object.
     * It takes a SQL query as a string, prepares it using the PDO connection, executes it,
     *  and returns the resulting PDOStatement object. 
     * If any exceptions occur during the execution of the query, 
     * it catches the PDOException and throws a RuntimeException with an appropriate error message.
     * @throws RuntimeException
     * @param string $sql
     * @return bool|PDOStatement
     */
    public function create(string $sql): PDOStatement
    {
        try {

            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new RuntimeException("{$this->driver} : " . $e->getMessage());
        }
    }

    /**
     * Summary of transaction
     * this method is responsible for executing a series of database operations within a transaction.
     * It takes a callable as an argument, which represents the operations to be performed within the transaction.
     * The method begins a transaction using the PDO connection, executes the provided callback function,
     * and commits the transaction if all operations are successful. 
     *If any exceptions occur during the execution of the callback,
     * it rolls back the transaction and throws a RuntimeException with an appropriate error message.
     * @param callable $callback 
     * @throws RuntimeException
     * @return mixed
     */
    public function toTransaction(callable|Select $callback, object $object): mixed
    {
        try {

            $this->connect()->beginTransaction();

            $data = \call_user_func($callback, $object);

            $this->connect()->commit();
            return $data;
        } catch (Throwable $e) {
            $this->connect()->rollBack();
            throw new RuntimeException("{$this->driver} => Transaction error : " . $e->getMessage());
        }
    }

    /**
     * Summary of getDatabase
     * @return string
     */
    public function getDatabase(): string
    {
        return $this->database;
    }

    /**
     * Summary of newConnection
     * @param array{host:string,port:int,charset:string} $dsn
     * @param string $username
     * @param string $password
     * @param array $options
     * @return static
     */
    public function newConnection(array $dsn, string $username, string $password, array $options = []): static
    {
        $this->host = $dsn['host'];
        $this->port = $dsn['port'];
        $this->username = $username;
        $this->password = $password;

        if (isset($dsn['charset'])) $this->charset = $dsn['charset'];
        if (!empty($options)) $this->options = $options;

        return $this;
    }

    /**
     * Summary of getDsn
     * this method is responsible for constructing and returning the Data Source Name (DSN) string used 
     * for connecting to the database.
     * The DSN string typically includes the database driver, host, port, database name, 
     * charset, and other relevant connection parameters.
     * The specific format of the DSN string may vary depending on the database driver being used (e.g., MySQL, SQLite).
     * This method is abstract and must be implemented by subclasses to provide 
     * the appropriate DSN string based on their specific configuration.
     * @throws PDOException
     * @return string
     */
    abstract protected function getDsn(): string;

    /**
     * Summary of getUsername
     * this method is responsible for construct and returning the usersName in mysql and SQLite
     * @return string
     */
    abstract protected function getUsername(): string;
    abstract protected function getPassword(): string;
    abstract protected function getOptions(): array;
}
