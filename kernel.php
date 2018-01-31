<?php

require __DIR__ . "/vendor/autoload.php";

use Pho\Kernel\Kernel;
use PhoNetworksAutogenerated\User;

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

$_grapho = \PhoNetworksAutogenerated\Graph::class;
$_user_params = ["123456"]; // password only

if(class_exists(\PhoNetworksAutogenerated\Twitter::class)) 
{
    $_grapho = \PhoNetworksAutogenerated\Twitter::class;
}
elseif(class_exists(\PhoNetworksAutogenerated\Facebook::class))
{
    $_grapho = \PhoNetworksAutogenerated\Facebook::class;
}
elseif(class_exists(\PhoNetworksAutogenerated\Site::class))
{
    $_grapho = \PhoNetworksAutogenerated\Site::class;   
    $_user_params = ["the_founder", "x@y.org", "123456"]; 
}

$configs = array(
  "services"=>array(
      "database" => ["type" => getenv('DATABASE_TYPE'), "uri" => getenv('DATABASE_URI')],
      "storage" => ["type" => getenv('STORAGE_TYPE'), "uri" =>  getenv("STORAGE_URI")],
      "index" => ["type" => getenv('INDEX_TYPE'), "uri" => getenv('INDEX_URI')]
  ),
  "default_objects" => array(
  		"graph" => $_grapho,
  		"founder" => User::class,
  		"actor" => User::class
  )
);

$kernel = new \Pho\Kernel\Kernel($configs);
$founder = new \PhoNetworksAutogenerated\User($kernel, $kernel->space(), ...$_user_params);
$kernel->boot($founder);

//$founder = $kernel->founder();
//$graph = $kernel->graph();
