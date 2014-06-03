<?php
class Session {

   public $userName;

   function __construct(){
       
      session_start();
   }

   function check() {
       
      if(!isset($_SESSION['username']) || !isset($_SESSION['password'])){

         $_SESSION['url'] = $_SERVER['REQUEST_URI'];

         header("Location: /pages/login.php");
      }

      return $_SESSION['loggedUserId'];

   }
   
   function end(){
      
      session_destroy();
      header("Location: /index.php");
   }
}
?>