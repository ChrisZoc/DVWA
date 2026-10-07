<?php
define( 'DVWA_WEB_PAGE_TO_ROOT', '../../' );
require_once DVWA_WEB_PAGE_TO_ROOT . 'dvwa/includes/dvwaPage.inc.php';

dvwaPageStartup( array( 'authenticated' ) );

header( 'Content-Type: application/json' );
if( dvwaCurrentUser() !== 'admin' ) {
	http_response_code( 403 );
	echo json_encode( array( 'result' => 'fail', 'error' => 'Access denied' ) );
	exit;
}

dvwaDatabaseConnect();

/*
On impossible only the admin is allowed to retrieve the data.
*/

if ($_SERVER['REQUEST_METHOD'] != "POST") {
	$result = array (
						"result" => "fail",
						"error" => "Only POST requests are accepted"
					);
	echo json_encode($result);
	exit;
}

try {
	$json = file_get_contents('php://input');
	$data = json_decode($json);
	if (is_null ($data)) {
		$result = array (
							"result" => "fail",
							"error" => 'Invalid format, expecting "{id: {user ID}, first_name: "{first name}", surname: "{surname}"}'

						);
		echo json_encode($result);
		exit;
	}
} catch (Exception $e) {
	$result = array (
						"result" => "fail",
						"error" => 'Invalid format, expecting \"{id: {user ID}, first_name: "{first name}", surname: "{surname}\"}'

					);
	echo json_encode($result);
	exit;
}

if( !isset( $data->id, $data->first_name, $data->surname ) ||
	filter_var( $data->id, FILTER_VALIDATE_INT, array( 'options' => array( 'min_range' => 1 ) ) ) === false ||
	!is_string( $data->first_name ) || !is_string( $data->surname ) ) {
	http_response_code( 400 );
	echo json_encode( array( 'result' => 'fail', 'error' => 'Invalid user data' ) );
	exit;
}

$query = "UPDATE users SET first_name = ?, last_name = ? WHERE user_id = ?";
$stmt = mysqli_prepare( $GLOBALS["___mysqli_ston"], $query );
$id = (int) $data->id;
mysqli_stmt_bind_param( $stmt, 'ssi', $data->first_name, $data->surname, $id );
$result = mysqli_stmt_execute( $stmt );
mysqli_stmt_close( $stmt );

print json_encode (array ("result" => "ok"));
exit;
?>
