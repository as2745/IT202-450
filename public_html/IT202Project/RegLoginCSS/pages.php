<?php
if (! (isset($_GET['pageNumber']))) {
    $pageNumber = 1;
} else {
    $pageNumber = $_GET['pageNumber'];
}

$perPageCount = 2;

require("config.php");
$email=$_SESSION["user"]["email"];
$account=$_GET["account"];
$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
$db = new PDO($connection_string, $dbuser, $dbpass);
$stmt = $db->prepare("SELECT count(*) as num FROM Transactions where Acc_Dst=:acc");
$stmt->execute(array(
	":acc" => $account
));
$res = $stmt->fetchAll();

$rowCount=$res[0]["num"];

$pagesCount = ceil($rowCount / $perPageCount);

$lowerLimit = ($pageNumber - 1) * $perPageCount;

$stmt = $db->prepare("SELECT * FROM Transactions  where Acc_Dst=:acc limit " . ($lowerLimit) . " ,  " . ($perPageCount) . " ");
$stmt->execute(array(
	":acc" => $account
));
$results = $stmt->fetchAll();

?>

<table class="table table-hover table-responsive">
    <tr>
        <th align="center">From</th>
        <th align="center">To<br>(in years)
        </th>
        <th align="center">Type</th>
		<th align="center">Amount</th>
		<th align="center">Date</th>
    </tr>
    <?php foreach ($results as $data) { ?>
    <tr>
        <td align="left">
            <?php echo $data['Acc_Src'] ?>
        </td>
        <td align="left">
            <?php echo $data['Acc_Dst'] ?>
        </td>
        <td align="left">
            <?php echo $data['Type'] ?>
        </td>
		<td align="left">
            <?php echo $data['Expected_Total'] ?>
        </td>
		<td align="left">
            <?php echo $data['Created'] ?>
        </td>
    </tr>
    <?php
    }
    ?>
</table>

<div style="height: 30px;"></div>
<table width="50%" align="center">
    <tr>

        <td valign="top" align="left"></td>


        <td valign="top" align="center">
            <?php
	for ($i = 1; $i <= $pagesCount; $i ++) {
    if ($i == $pageNumber) {
        ?> <a href="javascript:void(0);" class="current">
                <?php echo $i ?>
        </a> <?php
    } else {
        ?> <a href="javascript:void(0);" class="pages"
            onclick="showRecords('<?php echo $perPageCount;  ?>', '<?php echo $i; ?>');">
                <?php echo $i ?>
        </a> <?php
    } // endIf
} // endFor

?>
        </td>
        <td align="right" valign="top">Page <?php echo $pageNumber; ?>
            of <?php echo $pagesCount; ?>
        </td>
    </tr>
</table>
