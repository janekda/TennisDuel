   <div class="clubPrestige">
      Výdělek prestiže za týden: <b class="<?=$clubPrestigeClass?>"><?=$sumWeekPrestige?>
      </b>, je potřeba 27200, abychom měli 19 benefitů týdně.
      <table class="dayPrestige">
         <?=$dayPrestigeTableRow?>       
      </table>
   </div>
   
   <table style='left: 870px; top: 70px; position: absolute'>
   <?=$bestPlayerRows?>
   </table>

   <h3>Přehled hráčů za posledních 7 dnů</h3>
   <table border='1' class='playerAttributesTable'>
      <th>Jméno</th>
      <th>Level</th>
      <th>Prestiž</th>
      <th>Turnaje</th>
      <th>Zápasy</th>
      <th>Peníze</th>
      <th>Prohrané</th>
      <th>Údery</th>
      <th>Pohyb</th>
      <th>Kondice</th>
      <th>Aktivita</th>
      <?=$playerRows?>
   </table>