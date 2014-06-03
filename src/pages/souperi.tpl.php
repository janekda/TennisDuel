<script type="text/javascript">
      var $_POST = <?php echo json_encode($_POST); ?>;
      var yourLevel = $_POST["yourLevel"];
      if (yourLevel>14){
         document.getElementById("yourLevel").value = yourLevel;
      }
      
      var rangeLevel = $_POST["rangeLevel"];
      if (rangeLevel>0){
         document.getElementById("rangeLevel").value = rangeLevel;
      }
      
      var maxBasicDegree = $_POST["maxBasicDegree"];
      if (maxBasicDegree>50){
         document.getElementById("maxBasicDegree").value = maxBasicDegree;
      }
   </script>

<table>
   <form method="POST" action="souperi.php" id="souperi">
      <p>Zadejte levely s kterými můžete hrát. Hladina znamená průměr základních schopností. Soupeř má hodnoty údery-120, pohyb-130, kondici-110. Jeho
         hladina je 120.
      
      
      <td>level:</td>

      <td><input type="text" id="yourLevel" name="yourLevel" class="numbers" size="4"></td>
      <td>maximální hladina:</td>
      <td><input type="text" id="maxBasicDegree" name="maxBasicDegree" class="numbers" size="4">
      </td>
      <td>rozpětí (+-level):</td>
      <td><input type="text" id="rangeLevel" name="rangeLevel" size="4" class="numbers" value="1">
      </td>
      <td colspan="2"><input type="submit" value="Odeslat">
      </td>
      </tr>
   </form>
</table>


<?php if (empty($_POST)){exit;}?>
<h4>
   Počet hráčů "<?=$rivalsCount?>"
</h4>
<table border='1'>
   <th>Klub</th>
   <th>Jméno</th>
   <th>Level</th>
   <th>Prohrané</th>
   <th>Vyhrané peníze</th>
   <th>Údery</th>
   <th>Pohyb</th>
   <th>Kondice</th>
   <th>Hladina atributů</th>
   <?=$rivalTableRows?>
</table>

<p>Řazení tabulky je od nejnižší hladiny.
<p>
<p>
   Data jsou naposledy aktualizovaná v
   <?= $lastDate?>
   . Rozdíl od skutečnosti se postupně zvyšuje a největší je těsně před další aktualizací.
</p>


</body>
</html>
