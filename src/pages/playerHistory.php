<html>
<head>
<meta charset="UTF-8">
<title>All England Lawn Tennis Club</title>

<link rel="stylesheet" type="text/css" href="css/ae.css" />
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="js/ae.js"></script>
</head>

<body>

   <h1>All England Lawn Tennis And Croquette Club</h1>
   
   <a href='index.php'>Hlavní strana</a>
   <p>
      <a href='souperi.php'>Hledání soupeřů</a>, co dávají největší peníze
   </p>


   <?php
   include_once ("config.php");
   $playerId = (int)$_POST["playerId"];
   
   
   ?>
</body>
</html>
