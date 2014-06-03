<?php
/**
 * Oceněnění atributů.
 *
 * @author Honza
 *
 */
class CssClass {

   private $neededClubPrestige = 27200;
   private $cssClasses = array(-3 => "class3minus", -2 => "class2minus", -1 => "class1minus", 0 => "class0", 1 => "class1plus", 2 => "class2plus", 3 => "class3plus");
    
   /**
    * Po tisicovkach prestize.
    *
    * @param int $sumWeekPrestige
    * @return +-250 je prestige0, +-750 prestize1plus(minus)
    */
   function getClubPrestigeClass($sumWeekPrestige){

      $arrayId = 0;
      $differencePrestige = (int)$sumWeekPrestige - $this->neededClubPrestige;

      switch (true) {
         case $differencePrestige < -2500: $arrayId = -3;  break;
         case $differencePrestige < -1500: $arrayId = -2;  break;
         case $differencePrestige < -500: $arrayId = -1;  break;
         case $differencePrestige < 500: $arrayId = 0;  break;
         case $differencePrestige < 1500: $arrayId = 1;  break;
         case $differencePrestige < 2500: $arrayId = 2;  break;
         default: $arrayId = 3;  break;
      }

      $prestigeClass = $this->cssClasses[$arrayId];

      return $prestigeClass;
   }
   
    /**
    * Vraci absolutne, ne podle levelu.
    *
    * @param int $weekPlayerPrestige
    */
   function getPlayerPrestigeClass($weekPlayerPrestige){

      $arrayId = 0;
      
      switch (true) {
         case $weekPlayerPrestige < 50*7: $arrayId = -3;  break;
         case $weekPlayerPrestige < 80*7: $arrayId = -2;  break;
         case $weekPlayerPrestige < 110*7: $arrayId = -1;  break;
         case $weekPlayerPrestige < 140*7: $arrayId = 0;  break;
         case $weekPlayerPrestige < 170*7: $arrayId = 1;  break;
         case $weekPlayerPrestige < 200*7: $arrayId = 2;  break;
         default: $arrayId = 3;  break;
      }

      $playerPrestigeClass = $this->cssClasses[$arrayId];

      return $playerPrestigeClass;
   }
   
    /**
    *
    * @param int $weekTournamentsCount
    */
   function getPlayerTournamentsClass($weekTournamentsCount){

      $arrayId = 0;
      
      switch (true) {
         case $weekTournamentsCount < 2: $arrayId = -3;  break;
         case $weekTournamentsCount < 4: $arrayId = -2;  break;
         case $weekTournamentsCount < 6: $arrayId = -1;  break;
         case $weekTournamentsCount < 7: $arrayId = 0;  break;
         case $weekTournamentsCount < 9: $arrayId = 1;  break;
         case $weekTournamentsCount < 11: $arrayId = 2;  break;
         default: $arrayId = 3;  break;
      }

      $playerTournamentClass = $this->cssClasses[$arrayId];

      return $playerTournamentClass;
   }
   
    /**
    *
    * @param int $weekPlayerMatches
    */
   function getPlayerMatchesClass($weekPlayerMatches){

      $arrayId = 0;
      
      switch (true) {
         case $weekPlayerMatches < 10*7: $arrayId = -3;  break;
         case $weekPlayerMatches < 15*7: $arrayId = -2;  break;
         case $weekPlayerMatches < 20*7: $arrayId = -1;  break;
         case $weekPlayerMatches < 25*7: $arrayId = 0;  break;
         case $weekPlayerMatches < 35*7: $arrayId = 1;  break;
         case $weekPlayerMatches < 50: $arrayId = 2;  break;
         default: $arrayId = 3;  break;
      }

      $playerMatchesClass = $this->cssClasses[$arrayId];

      return $playerMatchesClass;
   }
   
    /**
    *
    * @param float $weekPlayerMatches
    */
   function getPlayerActivityClass($weekPlayerActivity){

      $arrayId = 0;
      switch (true) {
         case $weekPlayerActivity < -0.5: $arrayId = -3;  break;
         case $weekPlayerActivity < -0.25: $arrayId = -2;  break;
         case $weekPlayerActivity < 0: $arrayId = -1;  break;
         case $weekPlayerActivity < 0.25: $arrayId = 0;  break;
         case $weekPlayerActivity < 0.75: $arrayId = 1;  break;
         case $weekPlayerActivity < 1.25: $arrayId = 2;  break;
         default: $arrayId = 3;  break;
      }
      
      
      $playerActivityClass = $this->cssClasses[$arrayId];

      return $playerActivityClass;
   }
   
}
?>