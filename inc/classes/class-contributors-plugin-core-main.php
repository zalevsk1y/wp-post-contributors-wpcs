<?php

/**
 * Class add
 *
 * @package Contributors_Plugin_Core_Main
 * @author  Evgeniy S.Zalevskiy <2600@ukr.net>
 * @license MIT
 */

if ( ! class_exists( 'Contributors_Plugin_Core_Main' ) ) {

	class Contributors_Plugin_Core_Main {

		protected $sreen = 'post';
		protected $metabox;
		public function __construct() {

			$this->add_actions();
		}
		/**
		 * Add wp action hook
		 *
		 * @return void
		 */
		protected function add_actions() {

			add_action( 'admin_enqueue_scripts', array( $this, 'set_styles' ) );
		}
		/**
		 * Add styles
		 *
		 * @param string $hook
		 * @return void
		 */
		public function set_styles( $hook ) {
			if ( $hook == 'post.php' ) {
				\wp_enqueue_style( CONTRIBUTORS_PLUGIN_SLUG . '-style', CONTRIBUTORS_PLUGIN_URL . '/public/css/plugin-custom-styles.css' );
				\wp_enqueue_style( CONTRIBUTORS_PLUGIN_SLUG . '-fonts', CONTRIBUTORS_PLUGIN_URL . '/public/css/font.css' );
				wp_enqueue_script( CONTRIBUTORS_PLUGIN_SLUG . '-script', CONTRIBUTORS_PLUGIN_URL . '/public/js/contributor-script.js' );
			}
		}
	}
}
