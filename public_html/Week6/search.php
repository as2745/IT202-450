<?php
$search = "";
if(isset($_POST["search"])){
    $search = $_POST["search"];
}
?>
<html>
<body>
<form method="POST">
    <input type="text" name="search" placeholder="Search for Thing"
    value="<?php echo $search;?>"/>
    <input type="submit" value="Search"/>
</form>
<?php
if(isset($search) && strlen($search)>0) {
    require("common.inc.php");
    $query = file_get_contents(__DIR__ . "/queries/SEARCH_TABLE_THINGS.sql");
    if (isset($query) && !empty($query)) {
        try {
            $stmt = getDB()->prepare($query);
            //Note: With a LIKE query, we must pass the % during the mapping
            $stmt->execute([":thing"=>$search]);
            //Note the fetchAll(), we need to use it over fetch() if we expect >1 record
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
?>
<!--This part will introduce us to PHP templating,
note the structure and the ":" -->
<!-- note how we must close each check we're doing as well-->
<?php if(isset($results) && count($results) > 0):?>
        <!-- Here we'll loop over all our results and reuse a specific template for each iteration,
        we're also using our helper function to safely return a value based on our key/column name.-->
<?php
	echo "<table id=\"myTable\">";
	echo "<tr>";
	echo "<th onclick=\"sortTable(0);\">Name</th>";
	echo "<th>Number</th>";
	echo "<th>Type</th>";
	echo "<th onclick=\"sortTable(3);\">Balance</th>";
	echo "</tr>";
?>
        <?php foreach($results as $row):?>
		<?php echo "<tr>";?>
                <?php echo "<td>". get($row, "Name")."</td>"?>
		<?php echo "<td>". get($row, "Account_Number")."</td>"?>
		<?php echo "<td>". get($row, "Account_Type")."</td>"?>
		<?php echo "<td>". get($row, "Balance")."</td>"?>
		<?php echo "<td>"."<a href=\"delete.php?thingId=".get($row, "Account_Number")."\">Delete</a></td>";?>
		<?php echo "</tr>";?>
        <?php endforeach;?>
	<?php echo "</table>";?>
<?php else:?>
<?php endif;?>
<script>
function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("myTable");
  switching = true;
  //Set the sorting direction to ascending:
  dir = "asc"; 
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /*check if the two rows should switch place,
      based on the direction, asc or desc:*/
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      //Each time a switch is done, increase this count by 1:
      switchcount ++;      
    } else {
      /*If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again.*/
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}
</script></body>
</html>