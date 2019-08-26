<?php
/**
 * Contributors Plugin template render class.
 *
 * @package View
 */

if ( ! class_exists( 'Contributors_Plugin_Template_Render' ) ) {
	/**
	 * Class loading template file and render it with args. Args is not is not escaping,
	 * so please escape them in template or before passing to TemplateRender.
	 *
	 * PHP version 7.0
	 *
	 * @author  Evgeniy S.Zalevskiy <2600@ukr.net>
	 * @license MIT https://opensource.org/licenses/MIT
	 */
	class Contributors_Plugin_Template_Render {
		/**
		 * Path to template.
		 *
		 * @var string
		 */
		protected $path;
		/**
		 * Argument that should be passed to template.
		 *
		 * @var array
		 */
		protected $args;
		/**
		 * Init function
		 *
		 * @param string $template_path path to template.
		 * @param array  $args array of args that need to be add to template.
		 * @throws \Exception If template file does not exist throw an Exception.
		 */
		public function __construct( $template_path, $args = array() ) {
			if ( ! file_exists( $template_path ) ) {
				throw new \Exception( 'Cannot load template file ' . $template_path );
			}
			$this->path = $template_path;
			$this->args = $args;
		}
		/**
		 * Render template.
		 *
		 * @param array $args array of args that need to be add to template.
		 * @return string
		 */
		public function render( $args = [] ) {
			if ( count( $this->args ) > 0 ) {
				foreach ( $this->args as $key => $item ) {
					${$key} = $item;
				}
			}
			if ( count( $args ) > 0 ) {
				foreach ( $args as $key => $item ) {
					${$key} = $item;
				}
			}
			ob_start();
			include $this->path;
			$content = ob_get_contents();
			ob_end_clean();
			return $content;
		}
	}
}
