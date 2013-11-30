<?php header("Content-Type:text/html;charset=SHIFT_JIS"); ?>
<?php htmlHeader(); ?>
<h1>Mt. Fuji Live Camera</h1>
<?php
$now = new DateTime();
$now->sub(new DateInterval('P1M'));
$dir = $now->format('Y-m-d');
$file = $now->format('Y-m-d-H-i') . '.jpg';
//echo 'dir: ', $dir, "<br>\n";
//echo 'file: ', $file, "<br>\n";
echo 'time: ', $now->format('Y-m-d-H-i-s'), "<br>\n";
//echo '<image src="../zenphoto/albums/fujilog/',
//  $dir, '/', $file, '"><br>' . "\n";
//echo '<image src="', $dir, '/', $file, '">' . "<br>\n";
echo "<br>\n";
echo 'Last successful upload: '; 

$fp = fopen('current', 'r');
if($fp){
	$current = fread($fp, filesize('current'));
	echo $current . "<br>\n";
	echo '<image src="', $current, '">';
	fclose($fp);
}
else{
	echo 'not found';
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
