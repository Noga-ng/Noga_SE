<?php
namespace Noga\Core\ReadFileng\Parse;

class Parse{

    private const REG_INCLUDE = '/@include\(["\'](.+?)["\']\)/';
    private const REG_TYPE =
        '/^(string|int|bool|array|json)\s+(\w+)\s*=\s*([\s\S]*?)(?=^\s*(?:string|int|bool|array|json)\s+\w+\s*=|\z)/m';  
        
    private array|string|null $content = null;
    private string $include = '';
    private array $matches = [];

     public function __construct(private string $file)
    {
      $this->handle();
    }

    public function handle(){
         if (! is_file($this->file)) {
            throw new \RuntimeException("Configuration file not found: {$this->file}");
        }

        $this->content = file_get_contents($this->file);

        if ($this->content === false) {
            throw new \RuntimeException("Unable to read {$this->file}");
        }

        $this->content = preg_replace('/^\s*#.*$/m', '', $this->content);

        //load @include in principal files
        $this->content = preg_replace_callback(
            self::REG_INCLUDE,
            function (array $match): string {

                $this->include = dirname($this->file) . DIRECTORY_SEPARATOR . $match[1];

                if (! is_file($this->include)) {
                    throw new \RuntimeException(
                        "Included file not found: {$this->include}"
                    );
                }

                return file_get_contents($this->include);
            },
            $this->content
        );

        preg_match_all(
            self::REG_TYPE,
            $this->content,
            $this->matches,
            PREG_SET_ORDER
        );

        return $this;
    }
    public static function getConfig(string $file):array{
           $instance = new static($file);

        return $instance->matches;
    }
}