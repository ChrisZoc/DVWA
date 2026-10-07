<?php

if( isset( $_POST[ 'Submit' ] ) ) {
	// Get input
	$id = $_POST[ 'id' ];

	if( is_numeric( $id ) ) {
		$id = intval( $id );

		switch ($_DVWA['SQLI_DB']) {
			case MYSQL:
				$data = $db->prepare( 'SELECT first_name, last_name FROM users WHERE user_id = (:id) LIMIT 1;' );
				$data->bindParam( ':id', $id, PDO::PARAM_INT );
				$data->execute();

				while( $row = $data->fetch() ) {
					$first = $row[ 'first_name' ];
					$last  = $row[ 'last_name' ];
					$html .= "<pre>ID: {$id}<br />First name: {$first}<br />Surname: {$last}</pre>";
				}
				break;
			case SQLITE:
				global $sqlite_db_connection;

				try {
					$stmt = $sqlite_db_connection->prepare( 'SELECT first_name, last_name FROM users WHERE user_id = :id LIMIT 1;' );
					$stmt->bindValue( ':id', $id, SQLITE3_INTEGER );
					$results = $stmt->execute();
				} catch (Exception $e) {
					echo 'Caught exception: ' . $e->getMessage();
					exit();
				}

				if ($results) {
					while ($row = $results->fetchArray()) {
						$first = $row[ 'first_name' ];
						$last  = $row[ 'last_name' ];
						$html .= "<pre>ID: {$id}<br />First name: {$first}<br />Surname: {$last}</pre>";
					}
				}
				break;
		}
	}
}

$data = $db->query( 'SELECT COUNT(*) FROM users;' );
$number_of_rows = $data->fetchColumn();

?>
