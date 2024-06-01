<?php

/*
 | --------------------------------------------------------------------
 | App Namespace
 | --------------------------------------------------------------------
 |
 | This defines the default Namespace that is used throughout
 | CodeIgniter to refer to the Application directory. Change
 | this constant to change the namespace that all application
 | classes should use.
 |
 | NOTE: changing this will require manually modifying the
 | existing namespaces of App\* namespaced-classes.
 */
defined('APP_NAMESPACE') || define('APP_NAMESPACE', 'App');

/*
 | --------------------------------------------------------------------------
 | Composer Path
 | --------------------------------------------------------------------------
 |
 | The path that Composer's autoload file is expected to live. By default,
 | the vendor folder is in the Root directory, but you can customize that here.
 */
defined('COMPOSER_PATH') || define('COMPOSER_PATH', ROOTPATH . 'vendor/autoload.php');

/*
 |--------------------------------------------------------------------------
 | Timing Constants
 |--------------------------------------------------------------------------
 |
 | Provide simple ways to work with the myriad of PHP functions that
 | require information to be in seconds.
 */
defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR')   || define('HOUR', 3600);
defined('DAY')    || define('DAY', 86400);
defined('WEEK')   || define('WEEK', 604800);
defined('MONTH')  || define('MONTH', 2592000);
defined('YEAR')   || define('YEAR', 31536000);
defined('DECADE') || define('DECADE', 315360000);

/*
 | --------------------------------------------------------------------------
 | Exit Status Codes
 | --------------------------------------------------------------------------
 |
 | Used to indicate the conditions under which the script is exit()ing.
 | While there is no universal standard for error codes, there are some
 | broad conventions.  Three such conventions are mentioned below, for
 | those who wish to make use of them.  The CodeIgniter defaults were
 | chosen for the least overlap with these conventions, while still
 | leaving room for others to be defined in future versions and user
 | applications.
 |
 | The three main conventions used for determining exit status codes
 | are as follows:
 |
 |    Standard C/C++ Library (stdlibc):
 |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
 |       (This link also contains other GNU-specific conventions)
 |    BSD sysexits.h:
 |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
 |    Bash scripting:
 |       http://tldp.org/LDP/abs/html/exitcodes.html
 |
 */
defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          || define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         || define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       || define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      || define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      || define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


/*
|--------------------------------------------------------------------------
| Constants for Site
|--------------------------------------------------------------------------
|
*/

define('SITE_NAME', 'Pengisian Nilai');
define('SITE_PORT', '8081');


/*
|--------------------------------------------------------------------------
| Directotu Public for library encrypt AND decrypt
|--------------------------------------------------------------------------
|
*/

$dirPublic = '';
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
	/** DIR_PUBLIC_PROD FOR PRODUCTION LIB encrypt AND decrypt  */
	$dirPublic = realpath(ROOTPATH . "/../public_html/");
} else {
	/** DIR_PUBLIC_PROD FOR DEVELOPMENT LIB encrypt AND decrypt  */
	$dirPublic = ROOTPATH.'public';
}
define('DIR_PUBLIC_ASSETS', $dirPublic);


/*
|--------------------------------------------------------------------------
| Dynamic Base URL custom
|--------------------------------------------------------------------------
|
*/

$base = '';
if (isset($_SERVER['argv'])) {
	/** Dynamic BaseURL if Run On PHP Spark [ localhost/folder-name-project/public/ ] */
	// $_host = explode('=', $_SERVER['argv'][2])[1];	

	if (isset($_SERVER['HTTP_HOST'])) {
		/** Production */
		$base = $_SERVER['REQUEST_SCHEME']. '://' .$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/';
	} else {
		/** LocalHost */
		$base = "http://localhost:".SITE_PORT."/";	
	}
	
} else {
	/** Dynamic BaseURL if inject url [ localhost/folder-name-project/public/ ] */
	$base = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https://'.$_SERVER['HTTP_HOST'] : 'http://'.$_SERVER['HTTP_HOST'];
}
defined('BASE_URL')|| define('BASE_URL', $base);

/*
 * --------------------------------------------------------------------
 * LOAD THE BOOTSTRAP FILE
 * --------------------------------------------------------------------
 *
 * And away we go...
 */

define('SYSTEM_LIBRARIES', json_encode(json_decode(file_get_contents(ROOTPATH."/app/Config/Lib/config.app.json"), true)));