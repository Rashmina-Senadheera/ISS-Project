<?php

/**
 * Configuration file for CSRF Protector
 * Necessary configurations are (library would throw exception otherwise)
 * ---- failedAuthAction
 * ---- jsUrl
 * ---- tokenLength
 */
return array(
	"CSRFP_TOKEN" => "csrf_token",
	"failedAuthAction" => array(
		"GET" => 0,
		"POST" => 0
	),
	"errorRedirectionPage" => "",
	"customErrorMessage" => "",
	"jsUrl" => "http://localhost/is1109/libs/CSRF-Protector-PHP/js/csrfprotector.js",
	"tokenLength" => 10,
	"cookieConfig" => array(
		"path" => '',
		"domain" => '',
		"secure" => false,
		"expire" => time() + 60 *60,
	),
	"disabledJavascriptMessage" => "This site attempts to protect users against <a href=\"https://www.owasp.org/index.php/Cross-Site_Request_Forgery_%28CSRF%29\">
	Cross-Site Request Forgeries </a> attacks. In order to do so, you must have JavaScript enabled in your web browser otherwise this site will fail to work correctly for you.
	See details of your web browser for how to enable JavaScript.",
	"verifyGetFor" => array()
);
