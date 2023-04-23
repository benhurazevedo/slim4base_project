<?php 
namespace lib\config;

class Config 
{
  public static function getConfig() : array 
  {
    return [
        "dev" => true,
        "base-dir" => "http://localhost:3000",
        'JWT' => [
          'iss' => 'localhost',
          'aud' => 'localhost',
          'key' => 'girondino',
        ],
        'db' => [
          'DSN' => 'mysql:host=127.0.0.1;dbname=agenda',
          'DATABASE_USER' => 'root',
          'DB_PASSWORD' => '',
        ],
    ];
  }
}
?>
