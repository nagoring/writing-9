<?php
include_once dirname(__FILE__) . '/../lib/writing9_common.php';
define('ANY_WRITING9_TEST_PATH', dirname(__FILE__));
/**
 * PHPUnit bootstrap file
 *
 * @package Writing_9
 */

function any_test_method($class, $method, $args = null){
	$method = new ReflectionMethod(get_class($class), $method);
	$method->setAccessible(true);
	if($args === null){
		return $method->invoke($class);
	}else{
		return $method->invokeArgs($class, $args);
	}
}


$_tests_dir = getenv( 'WP_TESTS_DIR' );
if ( ! $_tests_dir ) {
	$_tests_dir = '/tmp/wordpress-tests-lib';
}

// Give access to tests_add_filter() function.
require_once $_tests_dir . '/includes/functions.php';

/**
 * Manually load the plugin being tested.
 */
function _manually_load_plugin() {
	require dirname( dirname( __FILE__ ) ) . '/writing-9.php';
}
tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

// Start up the WP testing environment.
require $_tests_dir . '/includes/bootstrap.php';
