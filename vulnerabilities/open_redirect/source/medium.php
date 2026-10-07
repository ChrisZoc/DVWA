<?php

if (array_key_exists ("redirect", $_GET) && $_GET['redirect'] != "") {
	if ($_GET['redirect'] !== 'info.php') {
		http_response_code (500);
		?>
		<p>You can only redirect to the info page.</p>
		<?php
		exit;
	} else {
		header ('location: info.php');
		exit;
	}
}

http_response_code (500);
?>
<p>Missing redirect target.</p>
<?php
exit;
?>
