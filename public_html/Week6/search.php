<form method="POST">
    <label for="acctype">Account_Type
	<input type="text" id="AccType" name="Account_Type" />
	</label>
    <input type="submit" value="Search"/>
</form>
<?php
//if(isset($search)) {
	$Acctyp = $_POST["Account_Type"];
	echo $Acctyp;
    require("common.inc.php");
    $query = file_get_contents(__DIR__ . "/queries/SEARCH_TABLE_THINGS.sql");
	echo $query;
    if (isset($query) && !empty($query)) {
        try {
            $stmt = getDB()->prepare($query);
            //Note: With a LIKE query, we must pass the % during the mapping
            $stmt->execute([":thing"=>$Acctyp]);
            //Note the fetchAll(), we need to use it over fetch() if we expect >1 record
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach($results as $row){
				echo '<li>';
                echo get($row, "name");
                echo get($row, "quantity");
                echo '<a href="delete.php?thingId=<?php echo get($row, "id");?>Delete</a>';
            echo '</li>';
			}
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
//}
?>
