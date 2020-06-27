<?php
$search = "";
if(isset($_POST["search"])){
    $search = $_POST["search"];
}
?>
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
    <ul>
        <!-- Here we'll loop over all our results and reuse a specific template for each iteration,
        we're also using our helper function to safely return a value based on our key/column name.-->
<?php
	echo "<table>";
	echo "<tr>";
	echo "<th>Name</th>";
	echo "<th>Number</th>";
	echo "<th>Type</th>";
	echo "<th>Balance</th>";
	echo "</tr>";
?>
        <?php foreach($results as $row):?>
		<?php echo "<tr>";?>
		<li>
                <?php echo "<td>". get($row, "Name")."</td>"?>
		<?php echo "<td>". get($row, "Account_Number")."</td>"?>
		<?php echo "<td>". get($row, "Account_Type")."</td>"?>
		<?php echo "<td>". get($row, "Balance")."</td>"?>
		<?php echo "<td>"."<a href=\"delete.php?thingId=".get($row, "Account_Number")."\">Delete</a></td>";?>
		<?php echo "</tr>";?>
            </li>
        <?php endforeach;?>
	<?php echo "</table>";?>
    </ul>
<?php else:?>
<?php endif;?>