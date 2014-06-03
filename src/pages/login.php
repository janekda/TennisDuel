<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login</title>
<link rel="stylesheet" type="text/css" href="/css/ae.css" />
<script type="text/javascript" src="/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="/js/ae.js"></script>
</head>
<body>
   <form action="" method="post">
      <table width="400" align="center" cellpadding="2" cellspacing="2">
         <tr>
            <td colspan="2"><? if(!isset($_POST['login'])){?>Použij jméno a heslo pro přihlášení. <? }else{ echo "".$final_report."";}?></td>
         </tr>
         <tr>
            <td>Jméno:</td>
            <td><input type="text" name="username" size="30" maxlength="25" class="loginElement">
            </td>
         </tr>
         <tr>
            <td>Heslo:</td>
            <td><input type="password" name="password" size="30" maxlength="25" class="loginElement">
            </td>
         </tr>
         <tr>
            <td>&nbsp;</td>
            <td><input type="submit" name="login" value="Login" /></td>
         </tr>
      </table>
   </form>
</body>
</html>
<?

if (empty($_POST)){

   exit;
}

require_once (__DIR__."/../classes/Session.php");
require_once (__DIR__."/../classes/Login.php");

$session = new Session;
$login = new Login;
$login->process();
?>
