<?
include_once (__DIR__."/../config.php");
require_once (__DIR__."/../classes/Session.php");
include_once (__DIR__."/../classes/CssClass.php");

$pagetitle = "Kritéria";
$subtitle = "Jak hrát klubové zápasy";


$content = "clubsRules.tpl.php";
include_once ("template.php");
?>