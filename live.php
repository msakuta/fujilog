<?php header("Content-Type:text/html;charset=SHIFT_JIS"); ?>
<?php htmlHeader(); ?>
<h1>Mt. Fuji Live Camera</h1>
<?php
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
