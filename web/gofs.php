<html> 
<link rel="stylesheet" type="text/css" href="main.css" />
<br />
<h2>GNU Octave Function Search</h2>
<br />
<form method="post" action="gofs.php">
Function: <input type="text" name="function">
<input class="button gray small" type="submit" name="Check" value=">> Search">
</form>
<?php
// options
$dbfile = 'fs.sql';

// inputs
$f = $_POST["function"];


// functionality
if (strlen($f) == 0) die('No Input was given');
if (!preg_match('/^[a-zA-Z_0-9]+$/i',$f)) die('Illegal characters');
if (strlen($f) > 64) die('Input is to long');

	$q = "SELECT host, package FROM fs WHERE func='$f'";
	$db = new SQLite3($dbfile);
	$result = $db->query($q);
	if (!$result) {
		echo "fuck this shit!<br >";
	} else {
		echo '<br /><ul>';
		while ($record = $result->fetchArray()) {
			if ( $record['host'] == "github" ) {
				echo '<li><p> <b>'. $f .'()</b> is available in '. $record['host'] .' package <a href="https://github.com/octave-de/octave-hub">' .$record['package'] .'</a></p></li>';
			} elseif ( $record['host'] == "forge" ) {
				echo '<li> <b>'. $f .'()</b> is available in '. $record['host'] .' package <a href="http://octave.sf.net/'. $record['package'] .'/index.html">' .$record['package'] .'</a></p></li>';
			}
		}
		echo '</ul>';
	}
	$db->close();
?>
<br /> <br />
<small><a href="https://github.com/octave-de/GOFS">Improve it!</a></small>


