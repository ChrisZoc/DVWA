<?php


$headerCSP = "Content-Security-Policy: default-src 'self'; script-src 'self'; object-src 'none'; base-uri 'self';";

header($headerCSP);

# These might work if you can't create your own for some reason
# https://cdn.jsdelivr.net/gh/digininja/csp_bypass/alert.js
# https://unpkg.com/@digininja/csp_bypass@1.0.0/index.js

?>
<?php
$page[ 'body' ] .= '
<form name="csp" method="POST">
	<p>External script inclusion is disabled.</p>
	<input size="50" type="text" name="include" value="" id="include" />
	<input type="submit" value="Include" />
</form>
<p>
	You will probably need to do some reading up on what some of the domains allowed by the CSP do and how they can be used.
</p>
';
