<?php

if( isset( $_POST[ 'Submit' ]  ) ) {
	// Get input
	$id = $_POST[ 'id' ];
	$exists = false;

	if( is_numeric( $id ) ) {
		$id = intval( $id );

		switch ($_DVWA['SQLI_DB']) {
			case MYSQL:
				try {
					$data = $db->prepare( 'SELECT first_name, last_name FROM users WHERE user_id = (:id) LIMIT 1;' );
					$data->bindParam( ':id', $id, PDO::PARAM_INT );
					$data->execute();
					$exists = $data->fetch() !== false;
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
		$html .= '<pre>User ID is MISSING from the database.</pre>';
	}
}

?>
