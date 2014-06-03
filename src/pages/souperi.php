<?
include_once (__DIR__."/../config.php");
require_once (__DIR__."/../classes/Session.php");

$session = new Session;
$loggedUser = $session->check();
   
$pagetitle = "Soupeři";
$subtitle = "Výběr soupeřů z klubů z klubů s MTC (GAC, Brooklyn, MTK, PROFÍCI Z MORAVY)";

$session = new Session;
$loggedUserId = $session->check();

$yourLevel = (int)$_POST["yourLevel"];
$rangeLevel = (int)$_POST["rangeLevel"];
$maxBasicDegree = (int)$_POST["maxBasicDegree"];

$RIVALS_SQL = "SELECT pa.playerId, p.name AS playerName, c.abbr AS clubName, level, ";
$RIVALS_SQL .= "FORMAT(lostMoney/1000,1) AS lostMoney, FORMAT(wonMoney/1000,1) AS wonMoney, strokeBasic, movementBasic, conditionBasic ";
$RIVALS_SQL .= " ,strokeAbility, movementAbility, conditionAbility, strokeHinterland, movementHinterland, conditionHinterland ";
$RIVALS_SQL .= " FROM PlayerAttribute AS pa ";
$RIVALS_SQL .= " JOIN Club AS c ON c.id = pa.clubId ";
$RIVALS_SQL .= " JOIN Player AS p ON p.id = pa.playerId ";
$RIVALS_SQL .= " JOIN (SELECT playerId, a.clubId, lastDate FROM PlayerAttribute AS a JOIN (SELECT clubId, MAX(date) AS lastDate FROM PlayerAttribute GROUP BY clubId)";
$RIVALS_SQL .= " AS d ON d.clubId=a.clubId GROUP BY playerId) AS pa2 ON pa2.playerId = pa.playerId AND DATEDIFF(pa2.lastDate, pa.date) = 0 ";
$RIVALS_SQL .= " WHERE (pa.level BETWEEN ".($yourLevel - $rangeLevel)." AND ".($yourLevel + $rangeLevel).") ";
$RIVALS_SQL .= " AND pa2.clubId IN (46, 83, 89, 262)";
$RIVALS_SQL .= " AND (strokeBasic + movementBasic + conditionBasic) < ".$maxBasicDegree."*3 ";
$RIVALS_SQL .= " ORDER BY (strokeBasic + movementBasic + conditionBasic), level";

$result = mysql_query($RIVALS_SQL);

$rivalsCount = mysql_num_rows($result);
if($result === FALSE) {
   die(mysql_error()); // TODO: better error handling
}

$playerRows = "";

while ($record = mysql_fetch_array($result)):

$playerId = $record["playerId"];
$playerName = $record["playerName"];
$level = $record["level"];
$lostMoney = $record["lostMoney"];
$wonMoney = $record["wonMoney"];
$clubName  = $record["clubName"];
$strokeBasic = $record["strokeBasic"];
$movementBasic = $record["movementBasic"];
$conditionBasic = $record["conditionBasic"];

$basicDegree = round(($strokeBasic + $movementBasic + $conditionBasic)/3);
$abilityDegree = round(($record["strokeAbility"] + $record["movementAbility"] + $record["conditionAbility"])/3, 1);
$hinterlandDegree = round(($record["strokeHinterland"] + $record["movementHinterland"] + $record["conditionHinterland"])/3, 1);

$anchor = "http://s3.tennisduel.cz/news/profile/?id=".$playerId;


$playerRow = "<tr><td class='player'>".$clubName."</td><td><a href='".$anchor."' target='_blank'>".$playerName."</a></td>";
$playerRow .= "<td class='level'>".$level."</td><td class='money'>".$lostMoney."</td><td class='money'>".$wonMoney."</td>";
$playerRow .= "<td class='attributes'>".$strokeBasic."</td><td class='attributes'>".$movementBasic."</td><td class='attributes'>".$conditionBasic."</td>";
$playerRow .= "<td class='attributes'>".$basicDegree."</td>";

$playerRows = $playerRows.$playerRow;
endwhile;

$rivalTableRows = $playerRows;

$LAST_ACTUALIZATION = "SELECT clubId, DATE_FORMAT(MAX(date), '%d.%m.%Y') AS lastDate  FROM PlayerAttribute WHERE clubId=89 GROUP BY clubId;";
$result = mysql_query($LAST_ACTUALIZATION);

if($result === FALSE) {
   die(mysql_error());
}

$lastActualizationDate = "";

while ($record = mysql_fetch_array($result)):

$lastDate = $record["lastDate"];
endwhile;

$content = "souperi.tpl.php";
include_once ("template.php");
?>