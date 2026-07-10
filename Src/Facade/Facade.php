<?php
namespace Noga\Facade;
use BadMethodCallException;
use LogicException;

abstract class Facade{
    protected static array $instance = [];
    protected ?string $className = null;

   protected static function getProcessInstance()
{
    $instance = new static();
    $instance->className = $instance->getProcessClass();
        
    if (!isset(self::$instance[$instance->className])) {
        self::$instance[$instance->className] = new $instance->className();
    }

    return self::$instance[$instance->className];
}

    protected function getProcessClass(): string{
        throw new LogicException("Error : Process class is not definied ! ");
    } 

    public function __call(mixed $method, mixed $args)
    {
        // On regarde quel processor peut gérer la méthode
        foreach (self::getProcessInstance() as $key => $class) {
            $instance = $key;
           $result = method_exists($instance, $method) ?
                        $instance->$method(...$args) :
                        $instance::$method(...$args);

             return $result;
            }  

        throw new BadMethodCallException("invalid method {$method}");
    }

     public static function __callStatic(mixed $method, mixed $args)
    {
             $instance = self::getProcessInstance();
             if(!method_exists($instance,$method)){
                throw new BadMethodCallException(" unknown method {$method}");
             }

            return $instance->$method(...$args);
    }

    public static function swap(string $key, object $instance)
        {
            static::$instance[$key] = $instance;
        }

}