<?php

require __DIR__ . '/impossible.php';
return;

// The page we wish to display
$file = $_GET[ 'page' ] ?? '';
if( !is_string( $file ) || !in_array( $file, array( 'include.php', 'file1.php', 'file2.php', 'file3.php' ), true ) ) {
	http_response_code( 404 );
	exit( 'ERROR: File not found!' );
}

?>
