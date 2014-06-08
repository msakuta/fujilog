<?php header("Content-Type:text/html;charset=SHIFT_JIS"); ?>
<?php
htmlHeader();
?>
<h1>Mt. Fuji Camera Log Index Page</h1>
<p>Welcome to Mt. Fuji Camera Log!</p>
<p>Common pages:</p>
<bl>
<li><a href="live.php">Most recent image of Mt. Fuji</a>
<li><a href="list.php">List of recent images</a>
<li><a href="daily.php">List of images at the same time of day</a>
<li><a href="stat.php">Statistics of recent images</a>
<li><a href="upload.log">Log of all uploaded images</a> WARNING! It's very large, probably megabytes long.
</bl>

<p>Following is a list of raw image directories, one directory per day:</p>
<bl>
<?php
if($dh = opendir("./")){
	$dirs = array();
	while(($file = readdir($dh)) !== false){
		// Don't print files or directories beginning with a dot.
		// Specifically, we don't want to expose .git directory
		// to the public; it's embarassing!
		if($file[0] == '.')
			continue;
		// Only print directories
		if(filetype($file) == "dir")
			array_push($dirs, $file);
	}

	// readdir() returns unordered list of directories.
	// Just inserting a line of code to sort it makes the list
	// so much convenient.
	sort($dirs);

	// TODO: Print file count to tell how the directories are filled.
	foreach($dirs as $file)
		echo '<li><a href="' . $file . '">' . $file . '</a>' . "\n";
}
?>
</bl>

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
