<?
if ($_SERVER["SERVER_ADDR"]=="localhost"){

   define("SQL_HOST","localhost");
   define("SQL_DBNAME","ae");
   define("SQL_USERNAME","jach");
   define("SQL_PASSWORD","abcde12369");
}
else{
   define("SQL_HOST","sql302.byethost31.com");
   define("SQL_DBNAME","b31_14122392_ae");
   define("SQL_USERNAME","b31_14122392");
   define("SQL_PASSWORD","abcde12369");
}

mysql_connect(SQL_HOST, SQL_USERNAME, SQL_PASSWORD) or die("Nelze se připojit k MySQL: " . mysql_error());
mysql_query("SET NAMES 'utf8'") or die('Could not set names');
mysql_select_db(SQL_DBNAME) or die("Nelze vybrat databázi: ". mysql_error());
?>