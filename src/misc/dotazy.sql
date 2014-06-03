SELECT *
FROM PlayerAttribute
WHERE playerId=70
ORDER BY DATE DESC;

-- vypis hracu z klubu
SELECT playerId, p.name AS playerName, MAX(level) AS currentLevel
  , MAX(level)-MIN(level) as levelMove, WEEK(`date`, 1) AS playerWeek
  , DATE_FORMAT(MIN(`date`), '%d.%m %H:%i') AS start
  , MAX(prestige) - MIN(prestige) AS weekPrestige
  , MAX(tournament) - MIN(tournament) AS weekTournament
  , MAX(wonMatch) - MIN(wonMatch) AS weekWonMatches
  , (SELECT MAX(wonMoney) FROM PlayerAttribute AS pa2 WHERE pa2.date=MAX(pa.date) AND pa2.playerId = pa.playerId) AS wonMoney
  , (SELECT MAX(lostMoney) FROM PlayerAttribute AS pa2 WHERE pa2.date=MAX(pa.date) AND pa2.playerId = pa.playerId) AS lostMoney
  , MAX(strokeBasic) AS actualStrokeBasic
  , MAX(movementBasic) AS actualMovementBasic
  , MAX(conditionBasic) AS actualConditionBasic
  , MAX(strokeBasic) - MIN(strokeBasic) AS weekStrokeAdvantage
  , MAX(movementBasic) - MIN(movementBasic) AS weekMovementAdvantage
  , MAX(conditionBasic) - MIN(conditionBasic) AS weekConditionAdvantage
FROM PlayerAttribute AS pa
JOIN Player AS p ON p.id = pa.playerId
WHERE pa.clubId = 336
  AND WEEK(`date`) = WEEK(CURDATE())
GROUP BY playerId, WEEK(`date`)
   ORDER BY level DESC, weekPrestige DESC;

-- vypis konkretniho hrace - aktivita po dnech
SELECT DATE_FORMAT(`date`,"%d.%m") AS datum
  , level
  , tournament AS turnajů
  , wonMoney AS `vyhrané peníze`
  , prestige AS prestiž
  , wonMatch AS `vítězné zápasy`
  , strokeBasic AS údery
  , movementBasic AS pohyb
  , conditionBasic AS kondice
FROM PlayerAttribute AS pa
JOIN Player AS p ON p.id = pa.playerId
WHERE pa.playerId = 4258
GROUP BY `date`
ORDER BY `date` DESC;

-- aktivita hracu v klubu
SELECT pa.level
  , p.name AS playerName
  , MAX(prestige) - MIN(prestige) AS weekPrestige
  , MAX(tournament) - MIN(tournament) AS weekTournament
  , MAX(wonMatch) - MIN(wonMatch) AS weekWonMatches
  , MAX(clubMatch) - MIN(clubMatch) AS clubMatches
FROM PlayerAttribute AS pa
JOIN Player AS p ON p.id = pa.playerId
WHERE pa.clubId = 336
  AND WEEK(`date`) = WEEK(CURDATE())
GROUP BY playerId, WEEK(`date`)
   ORDER BY level DESC, weekPrestige DESC;
   
SELECT abbr, Player.name, wonMoney
FROM PlayerAttribute
JOIN Player
  ON Player.id = PlayerAttribute.playerId
JOIN Club
  ON Club.id = PlayerAttribute.clubId
WHERE date>"2014-03-12"
ORDER BY wonMoney DESC
LIMIT 20;   

-- brklos(stenley), Egersdorf, Miranda, zajic
SELECT p.name AS opponent, m.datum
  , m.stroke AS myStroke
  , m.movement AS myMovement
  , m.condition AS myCondition
  , (m.stroke - o.stroke) AS diffStroke
  , (m.movement - o.movement) AS diffMovement
  , (m.condition - o.condition) AS diffCondition
  , (m.stroke - o.stroke) + (m.movement - o.movement) + (m.condition - o.condition) AS sumBasic
FROM (
  SELECT playerId, DATE_FORMAT(date, '%d.%m') AS datum
    , MAX(strokeBasic) AS stroke
    , MAX(movementBasic) AS movement
    , MAX(conditionBasic) AS `condition`
  FROM PlayerAttribute AS pa
  WHERE playerId = 10365
  GROUP BY DATE_FORMAT(date, '%d.%m')
) AS m
JOIN (
  SELECT playerId, DATE_FORMAT(date, '%d.%m') AS datum, date
    , MAX(strokeBasic) AS stroke
    , MAX(movementBasic) AS movement
    , MAX(conditionBasic) AS `condition`
  FROM PlayerAttribute AS pa
  WHERE playerId IN (3555, 5597, 723, 4364)
  GROUP BY playerId, DATE_FORMAT(date, '%d.%m')
) AS o
  ON o.datum = m.datum
JOIN Player AS p
  ON p.id = o.playerId
ORDER BY opponent, o.date;

-- seznam hracu
SELECT c.name AS clubName
  , p.name AS playerName
  , pa.level
  , FLOOR(pa.level/10) AS category
  , strokeBasic AS myStroke
  , movementBasic AS myMovement
  , `conditionBasic` AS myCondition
  , ROUND((strokeBasic + movementBasic + `conditionBasic`)/3,1) AS sumBasic
  , (pa.prestige - IFNULL(pa2.prestige,0)) AS playerWeekPrestige
FROM PlayerAttribute AS pa
LEFT JOIN (SELECT playerId, prestige FROM PlayerAttribute WHERE DATEDIFF("2014-03-23", date) = 0) AS pa2
  ON pa2.playerId= pa.playerId
JOIN Player AS p
   ON p.id = pa.playerId
JOIN Club AS c
   ON c.id = pa.clubId
WHERE DATEDIFF("2014-04-27", date) = 0
ORDER BY sumBasic DESC;

-- seznam hracu detailne
SELECT c.name AS clubName
  , p.name AS playerName
  , pa.level
  , FLOOR(pa.level/10) AS category
  , ROUND((strokeBasic + movementBasic + `conditionBasic`)/3,1) AS avgBasic
  , ROUND((strokeAbility + movementAbility + `conditionAbility`)/3,1) AS avgSkills
  , ROUND((strokeHinterland + movementHinterland + `conditionHinterland`)/3,1) AS avgFacilitie
  , (pa.prestige - IFNULL(pa2.prestige,0)) AS playerWeekPrestige
FROM PlayerAttribute AS pa
LEFT JOIN (SELECT playerId, prestige FROM PlayerAttribute WHERE DATEDIFF("2014-03-23", date) = 0) AS pa2
  ON pa2.playerId= pa.playerId
JOIN Player AS p
   ON p.id = pa.playerId
JOIN Club AS c
   ON c.id = pa.clubId
WHERE DATEDIFF("2014-04-27", date) = 0
ORDER BY avgBasic DESC;

-- fluktuace hracu v klubech
SELECT c.name
   , currentPlayers
   , playersInHistory
FROM Club AS c
JOIN (
   SELECT clubId
      , COUNT(DISTINCT playerId) AS currentPlayers
   FROM PlayerAttribute
   WHERE DATEDIFF("2014-04-27", date) = 0
   GROUP BY clubId
) AS cur
  ON cur.clubId = c.id
JOIN (
   SELECT clubId
      , COUNT(DISTINCT playerId) AS playersInHistory
   FROM PlayerAttribute
   GROUP BY clubId
) AS h
  ON h.clubId = c.id;
  
-- klubová prestiž po dnech za poslední 4 týdny
SELECT pa.myDate
  , (SUM(pa.maxPrestige) - SUM(prev.maxPrestige)) AS dayPrestige
FROM (
  SELECT DATE_FORMAT(date,'%d.%m') AS myDate
    , playerId, MAX(date) AS date
    , MAX(prestige) AS maxPrestige 
  FROM PlayerAttribute 
  WHERE clubId = 336
    AND DATEDIFF(DATE_ADD(CURDATE(), INTERVAL -1 DAY), date) <= 28 -- AND DATEDIFF(CURDATE(), date)>0
  GROUP BY clubId, myDate, playerId
) AS pa
JOIN (
   SELECT DATE_FORMAT(date,'%d.%m') AS myDate
      , playerId
      , MAX(date) AS date
      , MAX(prestige) AS maxPrestige
   FROM PlayerAttribute 
   WHERE clubId = 336
      AND DATEDIFF(DATE_ADD(CURDATE(), INTERVAL -2 DAY), date) <= 29
  GROUP BY clubId, myDate, playerId
) AS prev
   ON pa.playerId = prev.playerId AND DATEDIFF(
      DATE_ADD(pa.date, INTERVAL -1 DAY), prev.date) = 0
GROUP BY myDate
ORDER BY pa.date DESC;

-- klubová prestiž po týdnech
SELECT pa.myWeek, pa.lastWeekDay
  , (SUM(pa.maxPrestige) - SUM(prev.maxPrestige)) AS weekPrestige
FROM (
  SELECT DATE_FORMAT(date,'%v') AS myWeek
    , playerId, MAX(date) AS date
    , DATE_FORMAT(MAX(date),'%d.%m') AS lastWeekDay
    , MAX(prestige) AS maxPrestige 
  FROM PlayerAttribute 
  WHERE clubId = 336
    AND DATEDIFF(DATE_ADD(CURDATE(), INTERVAL -1 DAY), date) <= 28
  GROUP BY clubId, myWeek, playerId
) AS pa
JOIN (
   SELECT DATE_FORMAT(date,'%v ') AS myWeek
      , playerId
      , MAX(date) AS date
      , MAX(prestige) AS maxPrestige
   FROM PlayerAttribute 
   WHERE clubId = 336
      AND DATEDIFF(DATE_ADD(CURDATE(), INTERVAL -2 DAY), date) <= 29
  GROUP BY clubId, myWeek, playerId
) AS prev
   ON pa.playerId = prev.playerId AND pa.myWeek = prev.myWeek + 1
GROUP BY myWeek
ORDER BY pa.date DESC;
