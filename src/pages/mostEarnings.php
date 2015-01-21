<?
   include_once (__DIR__."/../config.php");
   require_once (__DIR__."/../classes/DB.php");
   
   $MAX_EARNING = "SELECT abbr, Player.name AS playerName, FORMAT(wonMoney/1000,1) AS wonMoneyFormatted FROM PlayerAttribute AS pa ";
   $MAX_EARNING .= "JOIN Player ON Player.id = pa.playerId ";
   $MAX_EARNING .= "JOIN Club ON Club.id = pa.clubId ";
   $MAX_EARNING .= "WHERE DATEDIFF(pa.date, (SELECT MAX(pa.date) FROM PlayerAttribute WHERE clubId=46))=0 ";
   $MAX_EARNING .= "ORDER BY wonMoney DESC LIMIT 20";

   $connection = DB::getConnection();
   $bestPlayerRows = "";

   foreach($connection->query($MAX_EARNING) as $row){
   
      $clubAbbr = $row["abbr"];
      $playerName = $row["playerName"];
      $wonMoney = $row["wonMoneyFormatted"];
       
      $bestPlayerRows .= "<tr><td>".$clubAbbr."</td><td class='player'>".$playerName."</td><td class='time'>".$wonMoney."</td></tr>";      
   }
   
   $bestPlayers = "mostEarnings.tpl.php";

?>
