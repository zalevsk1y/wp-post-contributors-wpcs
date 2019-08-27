<?php
/**
 * Contributors Plugin main class.
 *
 * @package Core
 */

if ( ! class_exists( 'Contributors_Plugin_Core_Main' ) ) {
	/**
	 * Class add scripts, styles and action hooks.
	 * 
	 * PHP version 5.6
	 *
	 * @package Contributors_Plugin_Core_Main
	 * @author  Evgeniy S.Zalevskiy <2600@ukr.net>
	 * @license MIT
	 */
	class Contributors_Plugin_Core_Main {
		/**
		 * Init function.
		 */
		public function __construct() {

			$this->add_actions();
		}
		/**
		 * Add wp action hook.
		 *
		 * @return void
		 */
		protected function add_actions() {

			add_action( 'admin_enqueue_scripts', array( $this, 'set_styles' ) );
		}
		/**
		 * Add styles.
		 *
		 * @param string $hook part of url.
		 * @return void
		 */
		public function set_styles( $hook ) {
			if ( 'post.php' === $hook ) {
				\wp_enqueue_style( CONTRIBUTORS_PLUGIN_SLUG . '-style', CONTRIBUTORS_PLUGIN_URL . '/public/css/plugin-custom-styles.css', array(), CONTRIBUTORS_PLUGIN_VERSION );
				\wp_enqueue_style( CONTRIBUTORS_PLUGIN_SLUG . '-fonts', CONTRIBUTORS_PLUGIN_URL . '/public/css/font.css', array(), CONTRIBUTORS_PLUGIN_VERSION );
				\wp_enqueue_script( CONTRIBUTORS_PLUGIN_SLUG . '-script', CONTRIBUTORS_PLUGIN_URL . '/public/js/contributor-script.js', array(), CONTRIBUTORS_PLUGIN_VERSION, false );
			}
		}
	}
}
