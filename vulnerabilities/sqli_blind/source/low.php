<?php

if( isset( $_GET[ 'Submit' ] ) ) {
	// Get input
	$id = $_GET[ 'id' ];
	$exists = false;

	if( is_numeric( $id ) ) {
		$id = intval( $id );

		switch ($_DVWA['SQLI_DB']) {
			case MYSQL:
				try {
					$data = $db->prepare( 'SELECT first_name, last_name FROM users WHERE user_id = (:id) LIMIT 1;' );
					$data->bindParam( ':id', $id, PDO::PARAM_INT );
					$data->execute();
					$exists = $data->rowCount() > 0;
				} catch (Exception $e) {
					print 'There was an error.';
					exit;
				}
				break;
			case SQLITE:
				global $sqlite_db_connection;

				try {
					$stmt = $sqlite_db_connection->prepare( 'SELECT COUNT(first_name) AS numrows FROM users WHERE user_id = :id LIMIT 1;' );
					$stmt->bindValue( ':id', $id, SQLITE3_INTEGER );
					$results = $stmt->execute();
					$row = $results->fetchArray();
					$exists = $row !== false && $row[ 'numrows' ] == 1;
				} catch(Exception $e) {
					$exists = false;
				}
				break;
		}
	}

	if ($exists) {
		$html .= '<pre>User ID exists in the database.</pre>';
	} else {
		header( $_SERVER[ 'SERVER_PROTOCOL' ] . ' 404 Not Found' );
		$html .= '<pre>User ID is MISSING from the database.</pre>';
	}
}

?>
