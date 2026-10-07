<?php

if( isset( $_POST['Change'] ) ) {
	checkToken( $_POST['user_token'] ?? '', $_SESSION['session_token'] ?? '', 'index.php' );
	$pass_curr = $_POST['password_current'] ?? '';
	$pass_new = $_POST['password_new'] ?? '';
	$pass_conf = $_POST['password_conf'] ?? '';
	$current_user = dvwaCurrentUser();

	$stmt = mysqli_prepare( $GLOBALS['___mysqli_ston'], 'SELECT password FROM users WHERE user = ? LIMIT 1' );
	mysqli_stmt_bind_param( $stmt, 's', $current_user );
	mysqli_stmt_execute( $stmt );
	$result = mysqli_stmt_get_result( $stmt );
	$row = $result ? mysqli_fetch_assoc( $result ) : null;
	mysqli_stmt_close( $stmt );

	if( is_array( $row ) && hash_equals( $row['password'], md5( $pass_curr ) ) &&
		$pass_new !== '' && hash_equals( $pass_new, $pass_conf ) ) {
		$password_hash = md5( $pass_new );
		$stmt = mysqli_prepare( $GLOBALS['___mysqli_ston'], 'UPDATE users SET password = ? WHERE user = ?' );
		mysqli_stmt_bind_param( $stmt, 'ss', $password_hash, $current_user );
		mysqli_stmt_execute( $stmt );
		mysqli_stmt_close( $stmt );
		$html .= '<pre>Password Changed.</pre>';
	} else {
		$html .= '<pre>Passwords did not match or current password incorrect.</pre>';
	}
}

generateSessionToken();

?>
