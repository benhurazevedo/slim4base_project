<?php 
namespace lib\services\dbService;
use \PDO;
use lib\config\Config;

class DBConnFactory
{
	public static function getConn() : PDO
	{
	  $config = Config::getConfig();

	  $conn = new PDO($config['db']['DSN'] , $config['db']['DATABASE_USER'], $config['db']['DB_PASSWORD']);
	  $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	  return $conn;
	}
}
?>