<?php declare(strict_types=1);
namespace Noga;
define("NOGA_SE_VERSION",'0.1.1');

use Noga\Facade\Facade;
use Noga\QueryBuilder\Crud\Delete\Delete;
use Noga\QueryBuilder\Crud\Insert\Insert;
use Noga\QueryBuilder\Crud\Update\Update;
use Noga\QueryBuilder\Select\Select;

/**
 * Summary of Noga design pattern static 
 * @method static Select table(string|callable|Select $table,string $alias = '')
 * @method static Select driver(?string $driver)
 * @method static Select database(?string $database = null)
 * @method static Select add_Query(string $key)
 * @method static Select use_query(string $key)
 * @method static Insert insert(string $table = '')
 * @method static Update update(string $table = '')
 * @method static Delete delete(string $table = '')
 * @method static Select with(string $cte, Select | callable $callback, ?bool $recursive = false)
 * @method static Select explain(callable | Select | string $explain, string $mode = '')
 * @method static mixed transaction(callable | Select $callback)
 * @mixin Select
 */
final class Noga extends Facade
{
     private static array $config = [
        'base_path' => '',
        'cache_path' => '',
        'driver' => 'mysql',
    ];

 /**
  * Summary of config
  * @param string $basePath `__DIR__`
  * @param string $cachePath 
  * @param string $driver 
  * @return void
  */
 public static function config(
        string $basePath,
        string $cachePath,
        string $driver = 'mysql'
    ): void {
        self::$config = [
            'base_path' => rtrim($basePath, DIRECTORY_SEPARATOR),
            'cache_path' => rtrim($cachePath, DIRECTORY_SEPARATOR),
            'driver'     => strtolower($driver),
        ];
    }

    /**
     * Summary of get
     * @param string $key
     * @return mixed
     */
    public static function get(string $key): ?string
    {
        return self::$config[$key] ?? null;
    }

  public function getProcessClass(): string
    {
        return Select::class; 
    } 
  
}
