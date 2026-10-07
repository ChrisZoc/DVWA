<?php

require __DIR__ . '/impossible.php';
return;

// The page we wish to display
$file = $_GET[ 'page' ] ?? '';

// Input validation
if( !is_string( $file ) || !in_array( $file, array( 'include.php', 'file1.php', 'file2.php', 'file3.php' ), true ) ) {
	// This isn't the page we want!
	echo "ERROR: File not found!";
	exit;
}

?>
