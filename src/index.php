<?
   include_once ("config.php");
   require_once ("classes/Session.php");
   include_once ("classes/CssClass.php");

   $session = new Session;
   $loggedUser = $session->check();
   
   $CLUB_ITC_COEFICIENT = 20200;

   $SUM_WEEK_PRESTIGE = "SELECT SUM(weekPrestige) AS sumWeekPrestige ";
   $SUM_WEEK_PRESTIGE .= "FROM ( ";
   $SUM_WEEK_PRESTIGE .= "SELECT playerId, MAX(prestige) - MIN(prestige) AS weekPrestige ";
   $SUM_WEEK_PRESTIGE .= "FROM PlayerAttribute AS pa ";
   $SUM_WEEK_PRESTIGE .= "WHERE clubId = 336 ";
   $SUM_WEEK_PRESTIGE .= "AND DATEDIFF(DATE_ADD(CURDATE(), INTERVAL -1 DAY), `date`) <= 7 AND DATEDIFF(CURDATE(), `date`)>0 ";
   $SUM_WEEK_PRESTIGE .= "GROUP BY playerId ";
   $SUM_WEEK_PRESTIGE .= ") AS m ";

   $WEEK_PRESTIGE_BY_DAY = "SELECT pa.myDate ";
   $WEEK_PRESTIGE_BY_DAY .= ", (SUM(pa.maxPrestige) - SUM(prev.maxPrestige)) AS dayPrestige ";
   $WEEK_PRESTIGE_BY_DAY .= "FROM ( ";
   $WEEK_PRESTIGE_BY_DAY .= "SELECT DATE_FORMAT(date,'%d.%m') AS myDate ";
   $WEEK_PRESTIGE_BY_DAY .= ", playerId, MAX(date) AS date ";
   $WEEK_PRESTIGE_BY_DAY .= ", MAX(prestige) AS maxPrestige "; 
   $WEEK_PRESTIGE_BY_DAY .= "FROM PlayerAttribute "; 
   $WEEK_PRESTIGE_BY_DAY .= "WHERE clubId = 336 ";
   $WEEK_PRESTIGE_BY_DAY .= "AND DATEDIFF(DATE_ADD(CURDATE(), INTERVAL -1 DAY), date) <= 6 AND DATEDIFF(CURDATE(), date)>0 ";
   $WEEK_PRESTIGE_BY_DAY .= "GROUP BY clubId, myDate, playerId ";
   $WEEK_PRESTIGE_BY_DAY .= ") AS pa ";
   $WEEK_PRESTIGE_BY_DAY .= "JOIN ( ";
   $WEEK_PRESTIGE_BY_DAY .= "SELECT DATE_FORMAT(date,'%d.%m') AS myDate ";
   $WEEK_PRESTIGE_BY_DAY .= ", playerId ";
   $WEEK_PRESTIGE_BY_DAY .= ", MAX(date) AS date ";
   $WEEK_PRESTIGE_BY_DAY .= ", MAX(prestige) AS maxPrestige ";
   $WEEK_PRESTIGE_BY_DAY .= "FROM PlayerAttribute "; 
   $WEEK_PRESTIGE_BY_DAY .= "WHERE clubId = 336 ";
   $WEEK_PRESTIGE_BY_DAY .= "AND DATEDIFF(DATE_ADD(CURDATE(), INTERVAL -2 DAY), date) <= 8 ";
   $WEEK_PRESTIGE_BY_DAY .= "  GROUP BY clubId, myDate, playerId ";
   $WEEK_PRESTIGE_BY_DAY .= ") AS prev ";
   $WEEK_PRESTIGE_BY_DAY .= "ON pa.playerId = prev.playerId AND DATEDIFF( ";
   $WEEK_PRESTIGE_BY_DAY .= "DATE_ADD(pa.date, INTERVAL -1 DAY), prev.date) = 0 ";
   $WEEK_PRESTIGE_BY_DAY .= "GROUP BY myDate ";
   $WEEK_PRESTIGE_BY_DAY .= "ORDER BY pa.date DESC; ";

   $PLAYERS_BASIC_SQL = "SELECT playerId, p.name AS playerName, MAX(level) AS currentLevel, MAX(level)-MIN(level) as levelMove, WEEK(`date`, 1) AS playerWeek, DATE_FORMAT(MIN(`date`), '%d.%m %H:%i') AS start, MAX(prestige) - MIN(prestige) AS weekPrestige";
   $PLAYERS_BASIC_SQL .= ", MAX(tournament) - MIN(tournament) AS weekTournament";
   $PLAYERS_BASIC_SQL .= ", MAX(wonMatch) - MIN(wonMatch) AS weekWonMatches";
   $PLAYERS_BASIC_SQL .= ", FORMAT((SELECT pa2.wonMoney FROM PlayerAttribute AS pa2 WHERE pa2.date=MAX(pa.date) AND pa2.playerId = pa.playerId)/1000, 1) AS wonMoney";
   $PLAYERS_BASIC_SQL .= ", FORMAT((SELECT pa2.lostMoney FROM PlayerAttribute AS pa2 WHERE pa2.date=MAX(pa.date) AND pa2.playerId = pa.playerId)/1000, 1) AS lostMoney";
   $PLAYERS_BASIC_SQL .= ", MAX(strokeBasic) AS actualStrokeBasic";
   $PLAYERS_BASIC_SQL .= ", MAX(movementBasic) AS actualMovementBasic";
   $PLAYERS_BASIC_SQL .= ", MAX(conditionBasic) AS actualConditionBasic";
   $PLAYERS_BASIC_SQL .= ", MAX(strokeBasic) - MIN(strokeBasic) AS weekStrokeAdvantage";
   $PLAYERS_BASIC_SQL .= ", MAX(movementBasic) - MIN(movementBasic) AS weekMovementAdvantage";
   $PLAYERS_BASIC_SQL .= ", MAX(conditionBasic) - MIN(conditionBasic) AS weekConditionAdvantage";
   $PLAYERS_BASIC_SQL .= " FROM PlayerAttribute AS pa";
   $PLAYERS_BASIC_SQL .= " JOIN Player AS p ON p.id = pa.playerId";
   $PLAYERS_BASIC_SQL .= " WHERE pa.clubId = 336 ";
   $PLAYERS_BASIC_SQL .= " AND DATEDIFF(DATE_ADD(CURDATE(), INTERVAL -1 DAY), `date`) <= 8 AND DATEDIFF(CURDATE(), `date`)>0 ";
   $PLAYERS_BASIC_SQL .= " GROUP BY playerId";
   $PLAYERS_BASIC_SQL .= " ORDER BY currentLevel DESC, weekPrestige DESC";

   $prestigeResult = mysql_query($SUM_WEEK_PRESTIGE);
   $sumWeekPrestige = 0;

   while ($record = mysql_fetch_array($prestigeResult)):

      $sumWeekPrestige = $record["sumWeekPrestige"];
   endwhile;

   $dayPrestigeResult = mysql_query($WEEK_PRESTIGE_BY_DAY);
   $dayPrestigeTableRow = "<tr>";

   $i=0;
   while ($record = mysql_fetch_array($dayPrestigeResult)):
   
      $oddCssClass = "evenDay";
      if ($i%2 == 0){
         $oddCssClass = "oddDay";
      }
      
      $dayPrestigeTableRow .= "<td class='".$oddCssClass."'>".$record["myDate"]."</td><td class='".$oddCssClass."'>".$record["dayPrestige"]."</td>";
      $i++;
   endwhile;
   $dayPrestigeTableRow .= "</tr>";
   
   $cssClass = new CssClass();

   $clubPrestigeClass = $cssClass->getClubPrestigeClass($sumWeekPrestige);
    

   $result = mysql_query($PLAYERS_BASIC_SQL);
   if($result === FALSE) {
      die(mysql_error()); // TODO: better error handling
   }

   $playerRows = "";

   while ($record = mysql_fetch_array($result)):

   $playerName = $record["playerName"];
   $currentLevel = $record["currentLevel"];
   $levelMove = $record["levelMove"];
   $weekPrestige = $record["weekPrestige"];
   $weekTournament = $record["weekTournament"];
   $weekWonMatches = $record["weekWonMatches"];
   $wonMoney = $record["wonMoney"];
   $lostMoney = $record["lostMoney"];
   $weekStrokeAdvantage = $record["weekStrokeAdvantage"];
   $weekMovementAdvantage = $record["weekMovementAdvantage"];
   $weekConditionAdvantage = $record["weekConditionAdvantage"];
   $weekActivity = ((float)$wonMoney + (float)$lostMoney)/($CLUB_ITC_COEFICIENT*24*(float)$currentLevel/1000000);
   $weekActivityFormatted = number_format($weekActivity, 1, ',', '');
    
   $playerPrestigeClass = $cssClass->getPlayerPrestigeClass($weekPrestige);
   $playerTournamentClass = $cssClass->getPlayerTournamentsClass($weekTournament);
   $playerMatchesClass = $cssClass->getPlayerMatchesClass($weekWonMatches);
   $playerActivityClass = $cssClass->getPlayerActivityClass($weekActivity);
    
   $playerRow = "<tr>";
   $playerRow .= "<td class='player'>".$playerName."</td>";
   $playerRow .= "<td class='level'>".$currentLevel."<span class='upperIndex'>(+".$levelMove.")</span></td>";
   $playerRow .= "<td class='prestige ".$playerPrestigeClass."'>".$weekPrestige."</td><td class='tournament ".$playerTournamentClass."'>".$weekTournament."</td>";
   $playerRow .= "<td class='".$playerMatchesClass."'>".$weekWonMatches."</td>";
   $playerRow .= "<td class='money'>".$wonMoney."</td><td class='money'>".$lostMoney."</td>";
   $playerRow .= "<td class='attributes'>".$weekStrokeAdvantage."</td><td class='attributes'>".$weekMovementAdvantage."</td><td class='attributes'>".$weekConditionAdvantage."</td>";
   $playerRow .= "<td class='".$playerActivityClass."'>".$weekActivityFormatted."</td></tr>";


   $playerRows = $playerRows.$playerRow;
   endwhile;

   $MAX_EARNING = "SELECT abbr, Player.name AS playerName, FORMAT(wonMoney/1000,1) AS wonMoneyFormatted FROM PlayerAttribute AS pa ";
   $MAX_EARNING .= "JOIN Player ON Player.id = pa.playerId ";
   $MAX_EARNING .= "JOIN Club ON Club.id = pa.clubId ";
   $MAX_EARNING .= "WHERE DATEDIFF(date, (SELECT MAX(date) FROM PlayerAttribute WHERE clubId=46))=0 ";
   $MAX_EARNING .= "ORDER BY wonMoney DESC LIMIT 20";

   $result = mysql_query($MAX_EARNING);
   if($result === FALSE) {
      die(mysql_error()); // TODO: better error handling
   }

   $bestPlayerRows = "";

   while ($record = mysql_fetch_array($result)):

   $clubAbbr = $record["abbr"];
   $playerName = $record["playerName"];
   $wonMoney = $record["wonMoneyFormatted"];

   $bestPlayerRows .= "<tr><td>".$clubAbbr."</td><td class='player'>".$playerName."</td><td class='time'>".$wonMoney."</td></tr>";

   endwhile;
   
   $content = "index.tpl.php";
   include_once ("pages/template.php");
?>
