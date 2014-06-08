<?php header("Content-Type:text/html;charset=UTF-8"); ?>
<?php
htmlHeader();

$start = strtotime("today");
// Obtain current time of day in seconds
$tod = time() - strtotime("today");
$freq = 1;
$maxc = 50;

// Prevent access to invalid keys
if(isset($_GET['start'])){
	$ex = explode('-', $_GET['start']);
	if(3 <= count($ex))
		$start = mktime(0, 0, 0, $ex[1], $ex[2], $ex[0]);
}
if(isset($_GET['tod'])){
	$ex = explode('-', $_GET['tod']);
	$tod = (int)$ex[0] * 3600;
	if(2 <= count($ex))
		$tod += (int)$ex[1] * 60;
}
if(isset($_GET['freq']))
	$freq = $_GET['freq'];
if(isset($_GET['maxc']))
	$maxc = $_GET['maxc'];

?>
<h1>Mt. Fuji Camera Daily View</h1>
<form mthod="GET" action="daily.php">
Start <input name="start" type="edit" value=<?php echo date('Y-m-d', $start);?> ><br>
Time of Day <input name="tod" type="edit" value=<?php echo '"' . floor($tod / 3600) . '-' . $tod / 60 % 60 . '"'; ?> ><br>
Interval 
<input name="freq" type="edit" value=<?php echo '"' . $freq . '"'; ?> >day<br>
Count <input name="maxc" type="edit" value=<?php echo '"' . $maxc . '"'; ?> ><br>
<input type="submit">
</form>
<?php

$now = $start + $tod;


function formatDate($t) {
	return date('Y-m-d/Y-m-d-H-i', $t) . '.jpg';
}


echo "<p>Start time: " . formatDate($now) . "</p>\n";
$timer = $now;
for($i = 0; $i < $maxc; $i++){
	echo ($i * $freq) . " days ago: " . formatDate($timer) . "<br>";
	echo '<a href="' . formatDate($timer) . '"><image src="' .
		formatDate($timer) . '", width=128, height=96></a><br>' . "\n";
	$timer = strtotime("-" . $freq . " day", $timer);
}

?>
<?php htmlFooter(); ?>

<?php function htmlHeader() { ?>


<HTML>
<HEAD>
<TITLE></TITLE>
</HEAD>
<BODY>

<?php } function htmlFooter() { ?>


</BODY>
</HTML>


<?php } ?>
