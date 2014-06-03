<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="UTF-8">
<title>All England Lawn Tennis Club - <?=$pagetitle?></title>
<link rel="stylesheet" type="text/css" href="/css/ae.css" />
<link rel="stylesheet" type="text/css" href="/css/style.css" />
<script type="text/javascript" src="/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="/js/ae.js"></script>

</head>
<body>
   <h1><a href="/index">All England Lawn Tennis And Croquette Club</a></h1>
   <h3>
   <?=$subtitle?>
   </h3>
   <div id="menu">
      <ul>
         <li><a href="/pages/clubsRules">Pravidla</a></li>
         <li><a href="/pages/souperi">Soupeři</a></li>
         <li><a href="/pages/clubsHistory.html">Historie</a></li>
         <li><a href="/pages/playerStats?<?=$loggedUserId?>">Moje Stats</a></li>
         <li><a href="/pages/sessionEnd">Logout</a></li>
      </ul>
   </div>
   <div id="page">
   <? include $content ?>
   </div>
</body>
</html>
