<?php declare(strict_types=1);
namespace Noga\QueryBuilder\Crud\Insert;

use finfo;
use InvalidArgumentException;
use Noga\Contracts\Insert\InsertInt;
use Noga\Traits\CacheQuery;
use PDOException;
use RuntimeException;
use Noga\Core\BindHashing;
use Noga\Traits\DbTrait;

final class Insert implements InsertInt
{
    use DbTrait;
    use CacheQuery;
    private string $file = "";
    private array $data = [];
    private ?InsertState $state = null;



    public function __construct()
    {
        $this->state = new InsertState('INSERT');
        $this->state->driver = $this->getDriver();
    }
    
    /**
     * Summary of table
     * @param string $table
     * @return Insert
     */
    public function table(string $table):Insert{
        $clone = clone $this;
        $clone->state->table = $table;
        return $clone;
    }

    /**
     * Summary of columns
     * @param string[] $columns
     * @return Insert
     */
    public function columns(string ...$columns):Insert
    {
        $clone = clone $this;
        $clone->state->columns = $columns;
        return $clone;
    }

    /**
     * Summary of values
     * @param string|int|bool $values
     * @return Insert
     */
    public function values(string|int|bool ...$values):Insert{
        $clone = clone $this;
        $clone->state->values = array_merge($clone->state->values,$values);
        return $clone;
    }

     /**
      * Summary of from
      * @param string $file
      * @throws InvalidArgumentException
      * @throws RuntimeException
      * @return Insert
      */
     public function from(string $file):Insert{
        $clone = clone $this;
        $finfo = new finfo(\FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file,\FILEINFO_MIME_TYPE);

        if(\file_exists($file)){
            if($mime !== "application/json"){
                throw new InvalidArgumentException("Invalid type mime json validate !");
            }
        }else{
            throw new RuntimeException("failed to open stream : {$file} ");
        }

        $clone->file = $file;
        
        return $clone;
    }

    /**
     * Summary of except
     * @param string[] $columns
     * @return Insert
     */
    public function except(string ...$columns):Insert{
        $clone = clone $this;
        $clone->state->except = \array_merge($clone->state->except,$columns);
        return $clone;
    }

    /**
     * Summary of take
     * @throws RuntimeException
     * @return Insert
     */
    public function take():Insert{
        $clone = clone $this;

        $json = \file_get_contents($clone->file);
        $data = \json_decode($json,true);
        
        if(!\is_array($clone->data)){
            throw new RuntimeException("Invalid JSON values. ");
        }
        
         $columns = \array_diff(array_keys($data[0]),$clone->state->except);
         $clone->state->columns = $columns;
        foreach ($data as $raws) {
            $values = [];
            foreach ($columns as $col) {
                $values[] = $raws[$col] ?? null;
            }
            $clone->state->values[] = $values;
        }

       return $clone;

    }

    /**
     * Summary of binding
     * @return static
     */
    private function binding():static{
        $key = [];
        $keys = "";
        foreach($this->state->columns as $k => $cols){
            $keys = BindHashing::hash('in',$cols);          
            if(\is_array($this->state->values[0])){
                  $key[] = $keys;
               $this->state->params = $this->bulkBinding($key,$this->state->params);
            }
              $this->state->params[$keys] = $this->state->values[$k];
              $this->state->bind[] = $keys;
        }

        return $this;
    }

    /**
     * Summary of bulkBinding
     * @param array $key
     * @param array $values
     * @return array
     */
    private function bulkBinding(array $key,array $values):array{
        $params = [];
        
        foreach($values as $k => $v){
            foreach($v as $ke => $c){
                $s = $key[$ke] ?? null;
                $params[$k][$s] = $c;
            }
        }
        
        return $params;
    }

    /**
     * Summary of compile
     * @return string
     */
    private function compile():string{
        $this->binding();
        return InsertCompiler::toSql($this->state);
    }

    /**
     * Summary of exc
     * @throws PDOException
     * @return bool|string
     */
    public function exec():string|bool{
        $this->stmt = $this->db()
            ->execute($this->compile(),$this->state->params);
         if(!$this->stmt) throw new PDOException("Error  : ".$this->stmt->errorInfo());

         return $this->db()->lastId();
    }
 
    public function getQuery():string{
        return $this->compile();
    }

    /**
     * Summary of debugSql
     * @return array
     */
    public function viewState():array{
        $this->binding();
        return $this->state->toArray();
    }





}
