<?php

require_once ('Config.php');


class DB {

   protected static $db;

   private function __construct()
   {

      try {

         $dsn = sprintf('mysql:host=%s; dbname=%s', SQL_HOST, SQL_DBNAME);
         self::$db = new PDO($dsn, SQL_USERNAME, SQL_PASSWORD);
         
      } catch (PDOException $e) {
         echo "Connection Error: " . $e->getMessage() ."  dsn=". $dsn;
      }
   }

   public static function getConnection()
   {
      //Guarantees single instance, if no connection object exists then create one.
      if (!self::$db) {
         new DB();
      }
      
      return self::$db;
   }

}
?>



