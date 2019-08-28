<?php
/**
 * Autoload function.
 *
 * @package Main
 */

/**
 * Autoload function.
 *
 * @param string $class Class name.
 * @return void
 */
function contributors_plugin_autoload( $class ) {
	$file_name = 'class-' . str_replace( '_', '-', strtolower( $class ) ) . '.php';
	$path      = __DIR__ . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . $file_name;

	if ( file_exists( $path ) ) {
		include $path;
	}
}

spl_autoload_register( 'contributors_plugin_autoload' );
