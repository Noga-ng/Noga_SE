<?php declare(strict_types=1);
namespace Noga\CLI\Services;

use Noga\CLI\Renderer\Color\Colors;
use Noga\CLI\Renderer\Renderer;
use Noga\CLI\Renderer\Type\Enum\Color;
use Noga\Noga;

final class Init
{
    private array $argv = [];
    public function __construct(array $args = [])
    {
       $this->argv = $args;
    }

    public function init():void
    {   
        
        $dir = Noga::get("base_path") .'/Config/';
        $file = "{$dir}ngconfig.ng";

           if($this->argv[2] === "--dump"){
         $cont = \file_get_contents($file);

        echo " configuration Noga : ". Colors::paint('ngconfig.ng',Color::YELLOW)."\n";
        echo "----------------------------------------\n";
        echo "$cont \n";
        echo "----------------------------------------\n";
        return;
    }

        echo "---------------------------------------------------------------------------\n";
              echo Colors::paint("WELCOME TO NOGA FRAMEWORK INIT CONFIGURATION FILE GENERATOR\n",Color::GREEN);
        echo "----------------------------------------------------------------------------\n";
        echo "This utility will help you create a configuration file for your ".Colors::paint("Noga",Color::YELLOW)."\n\n";
        echo "\n";
        echo "\n";
    
    $choose = ask("vous avez creer vraiment cette fichier de configuration (Y\N) ");
       

    if(\in_array($choose,['Y','y'])){
       
    if (file_exists($file)) {
        echo "⚠️".Colors::paint(" Le fichier de configuration 'ngconfig.ng' existe déjà.\n",Color::RED);

        $cont = \file_get_contents($file);

        echo "Contenu actuel du fichier:\n";
        echo "----------------------------------------\n";
        echo $cont . "\n";
        echo "----------------------------------------\n";
        
        return; 
    }

    if(!is_dir($dir)){
        mkdir($dir,0777,true);
    }

    $content = self::fileContent('ngconfig');
    file_put_contents($file, $content);

    echo "✅ Fichier de configuration ".Colors::paint("ngconfig.ng",Color::YELLOW)." créé avec succès dans le dossier $file.\n";

    }else if(\in_array($choose,["N","n"])){
        return;
    }

}


public static function boot(array $command = []){
    echo "---------------------------------------------------------------------------\n";
    echo "-------------------------- ". Colors::paint("WELCOME TO THE NOGA",Color::GREEN)." -----------------------\n";
    echo "----------------------------------------------------------------------------\n";
    echo "-------------------------- ".Colors::paint("version ".\NOGA_SE_VERSION,Color::GREEN)." ----------------------\n";
    echo "\n";
    echo "\n";
    echo "----------------------------------------------------------------------------\n";
    echo "----------------------------- "; Colors::success('COMMAND'); echo " ----------------------------\n";
    echo "\n";
    echo "\n";

    Renderer::data($command)->arr();

    return;
} 

public static function fileContent(string $name){
    return '# ng-config '.\NOGA_SE_VERSION.'
# Configuration file for the mini-framework noga application
# Database settings
# Adjust these settings according to your environment

#  ============= mysql
string DB_HOST = "localhost"
int DB_PORT = 3306

#  ============ Database connection settings name of users

string MY_USERSNAME = "root"
string MY_PASSWORD = ""
string MY_DATABASE = "msbc"
string MY_DRIVER = "mysql"
string MY_CHARSET = "utf8mb4"
string MY_COLLATION = "utf8mb4_unicode_ci"

array MY_OPTIONS = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false
]

# ================= Database Sqlite connection settings config

string Lite_driver = "sqlite"
string Lite_db = "Sqlite.db"
string Lite_foreign_keys = "PRAGMA foreign_keys = ON"
array Lite_option = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false
]

# ================== Database postgreSQL connection  settings config

string PG_HOST = "localhost"
int PG_PORT = 5432
string PG_USERSNAME = "postgres"
string PG_PASSWORD = "426513"
string PG_DATABASE = "postgres"
string PG_DRIVER = "pgsql"
string PG_CHARSET = "UTF-8"

array PG_OPTIONS = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false
]

    ';
}


}
