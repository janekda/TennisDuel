<?php
require_once ("DB.php");


class Login {

   public $userName;

   function process(){

      $calledUrl = $_SESSION['url'];

      $isSession =  isset($_SESSION['username']) && isset($_SESSION['password']);
      if($isSession){
         header("Location: $calledUrl");
         return ;
      }

      if(isset($_POST['login'])){

         $username= trim($_POST['username']);
         $password = trim($_POST['password']);

         if($username == NULL OR $password == NULL){

            $final_report.="Vyplň všechna pole ...";
         }
      }

      $connection = DB::getConnection();
      $query = "SELECT username, password FROM Member AS m WHERE `username` = '$username'";
      
      $result = $connection->query($query);
      $get_user_data = $result->fetch(PDO::FETCH_ASSOC);
      if(count($get_user_data) == 0){

         $final_report.="Takové jméno neexistuje";
      }else{

         if($get_user_data['password'] != $password){

            $final_report.="Špatné heslo!";
         }else{

            $_SESSION['id'] = "".$get_user_data['loggedUserId']."";
            $_SESSION['username'] = "".$get_user_data['username']."";
            $_SESSION['password'] = "".$get_user_data['password']."";
            $final_report.="Jsi přihlášen počkej chvilku..";
         }}

         echo $final_report." , url=".$calledUrl;
         header("Location: $calledUrl");
   }
}
?>