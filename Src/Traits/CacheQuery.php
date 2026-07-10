<?php
namespace Noga\Traits;

use Noga\Core\CacheManager;

trait CacheQuery{

  private string $cacheDir = "sql";

   /**
     * Summary of deepCopy
     * @param mixed $data
     * @return mixed
     */
    private function deepCopy(mixed $data)
    {
        return unserialize(serialize($data));
    }
    
    private function cache(string $key): CacheManager
    {
        return CacheManager::key($key)->dir($this->cacheDir);
    }

    /**
     * Summary of removeCache
     * @param string $key
     * @return string|null
     */
    public static function removeCache(string $key):?string{
            $instance = new static();
           $delete = $instance->cache($key)
                    ->delete()
                    ->debug();

        return $delete;
    }

   /**
    * Summary of removeAllCache
    * @return string|null
    */
   public static function removeAllCache():string{
        $instance = new static();
        $clearAll = CacheManager::clearAll($instance->cacheDir)
                    ->debug();
    
        return $clearAll;
   }

}