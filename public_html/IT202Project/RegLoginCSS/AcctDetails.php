
<?php
include("header.php");
require("common.inc.php");
require("config.php");
$email=$_SESSION["user"]["email"];
$account=$_GET["account"];
$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
$db = new PDO($connection_string, $dbuser, $dbpass);
$stmt = $db->prepare("SELECT Distinct Type as num FROM Transactions where Acc_Dst=:acc");
$stmt->execute(array(
	":acc" => $account
));
$res = $stmt->fetchAll();
$e = $stmt->errorInfo();
if($e[0] != "00000"){
	var_dump($e);
	echo "setting eee ".$e."<br>";
}
$stmt1 = $db->prepare("SELECT * FROM Bank_Accounts where Account_Number=:acc");
$stmt1->execute(array(
	":acc" => $account
));
$result = $stmt1->fetchAll();
$e = $stmt1->errorInfo();
if($e[0] != "00000"){
	var_dump($e);
	echo "setting eee ".$e."<br>";
}
$type=$result[0]["Account_Type"];
$amount=$result[0]["Balance"];

echo "<h3>Details of ".$account."</h3>";
echo "<h4>Account Type: ".$type."</h4>";
echo "<h4>Balance : $".$amount."</h4>";
?>

<input type="date" placeholder="From Date" id="post_at" name="post_at"   />
	    <input type="date" placeholder="To Date" id="post_at_to_date" name="post_at_to_date" style="margin-left:10px"    />			 
		
<br>
<select name="types" id="types">
	<option value=""></option>
		<?php
        foreach($res as $item){
        ?>
        <option value="<?php echo strtolower($item["num"]); ?>"><?php echo $item["num"]; ?></option>
        <?php
        }
        ?>
	</select>
<button onclick="showRecords(2,1)">Search</button>
<script
    src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<div id="container">
	<div id="inner-container">
		<div id="results"></div>
		<div id="loader"></div>
	</div>
  </div>
<script type="text/javascript">
    function showRecords(perPageCount, pageNumber) {
	    var acc = "<?php echo $account; ?>";
	    var post_at = document.getElementById("post_at").value;
	    var post_at_to_date = document.getElementById("post_at_to_date").value;
	    var e = document.getElementById("types");
	    var strUser = e.options[e.selectedIndex].value;
        $.ajax({
            type: "GET",
            url: "pages.php",
            data: {"pageNumber": pageNumber,"account": acc, "datefrom": post_at, "dateto": post_at_to_date, "type": strUser},
            cache: false,
    		beforeSend: function() {
                $('#loader').html('<img src="loader.png" alt="reload" width="20" height="20" style="margin-top:10px;">');
    			
            },
            success: function(html) {
                $("#results").html(html);
                $('#loader').html(''); 
            }
        });
    }
    
    $(document).ready(function() {
	    $( "#post_at" ).datepicker();
	    $( "#post_at_to_date" ).datepicker();
        showRecords(2, 1);
    });
</script>
