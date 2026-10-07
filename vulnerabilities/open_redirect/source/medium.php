<?php

if (isset($_GET['redirect']) && is_string($_GET['redirect']) && preg_match('/^(?!\/\/)(?:\/(?!\/)|[A-Za-z0-9])[A-Za-z0-9\/._~?&=%#-]*$/D', $_GET['redirect'])) {
	header ("Location: " . $_GET['redirect']);
	exit;
}

http_response_code (500);
?>
<p>Missing redirect target.</p>
<?php
exit;
?>
