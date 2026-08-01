<?php 
declare(strict_types=1);
namespace Noga\CLI\Command;

use Noga\CLI\Exceptions\InvalidCommandArgument;
use Noga\CLI\Renderer\Color\Colors;
use Noga\CLI\Renderer\Renderer;
use Noga\Core\CacheManager;
use Noga\Exceptions\InvalidQueryArgumentException;
use Noga\Exceptions\NotFountException;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

final class Command
{
    private array $dir = [];
    private array $class = [];
    private array $command = [];
    private ?CacheManager $cache = null;

    private static ?self $instance = null;

    public function __construct(array|string|null $dir = null)
    {
        $this->cache = CacheManager::key("commands")->dir("command");
            $this->setDirs($dir);

        $this->handle();
    }

    public static function get(string|array|null $dir = null): self
    {
        $dirs = [];
            $dirs = $dir;

        if(self::$instance === null){
            self::$instance = new self($dirs);
        }
        return self::$instance;
    }

    public function dir(string|array|null $dir = null): static
    {
            $this->setDirs($dir);

        return $this;
    }

    private function setDirs(string|array|null $dir): array
    {
        $dirs = self::normalizeDirs($dir);

        if(\is_array($dirs)){
             $this->dir = $dirs;
        }else{
            $this->dir[] = $dirs;
        }
       
        return $this->dir;
    }

    private static function normalizeDirs(string|array|null $dir)
    {
        $dirs = [];

        if (\is_array($dir)) {
            foreach ($dir as $path) {
                $dirs[] = __DIR__ . "/../../../".trim($path, '/');
            }
        } else if(\is_null($dir)) {

            $dirs = __DIR__ . "/../../../";

        }else{
            $dirs[] = __DIR__ . "/../../../".trim($dir,"/");
        }

        return $dirs;
    }

    public function handle()
    {
        $this->command = [];
        $this->class = [];

        if (!\is_array($this->dir)) {
          throw new InvalidCommandArgument("cache dir most be of type array");
        }

        foreach ($this->dir as $dir) {

            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator(
                    $dir,
                    \FilesystemIterator::SKIP_DOTS
                )
            );

            foreach ($files as $f) {

                if (!$f->isFile() || $f->getExtension() !== 'php') {
                    continue;
                }
                $basePath = \dirname(__DIR__,3);

                $file = trim(str_replace(
                    [$basePath, ".php"],
                    ['', ''],
                    $f->getRealPath()
                ),"\\");

               

                $getname = explode('\\', $file);
                $name = ucfirst(end($getname));

                $class = ucwords($file, '\\');
               
                if (\in_array($name, ['Command', 'Kernel'])) {
                    continue;
                }

                $this->class[] = $class;
                $this->command[$name] = (\str_starts_with($class,'Tests')) ? "Noga\\$class" : str_replace('Src','Noga',$class);
                 
            }      

        }
         return $this;
    }

    public function put(): void
    {
        $cache = $this->cache->data($this->command)->put();

        Colors::success(
            "Command cache generated (" . \count($this->command) . " commands)\n in {$cache->getPath()}"
        );

        return;
    }

    public function show(): void
    {
        $cache = $this->cache->get();

        if (!\is_array($cache) || !isset($cache['data']) || !\is_array($cache['data'])) {
            Colors::warning("no command available !");
            return;
        }

        Renderer::data($cache['data'])->arr();
    }

    public function clear(): void
    {
        if ($this->cache->has()) {
            $this->cache->delete();
            Colors::success("cache deleted !");
            return;
        }
        Colors::error('Cache is not found ');
        return;
    }

    public function list():array
    {
        $command = [];
        $comm = $this->cache->get();
        $command = !empty($comm) ? $comm['data'] : $this->command;

        return $command;
    }

    public function command(string $key = ""): void
    {
        $cache = $this->cache->get();

        if (\is_array($cache) && isset($cache['data'])) {
            $this->command = $cache['data'];
        }

        $com = isset($this->command[$key])
            ? "$key => {$this->command[$key]}"
            : "Command not Found $key";

        Colors::success($com);
    }

    public function add(string $key, string $command): static
    {
        $this->command[$key] = $command;

        return $this;
    }
}