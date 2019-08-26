<?php
/**
 * Contributors Plugin custom exception class.
 *
 * @package Exception
 */

if ( ! class_exists( 'Contributors_Plugin_My_Exception' ) ) {
	/**
	 * Class for handle plugins exception.
	 *
	 * PHP version 7.0
	 *
	 * @package  Exception
	 * @author   Evgeniy S.Zalevskiy <2600@ukr.net>
	 * @license  MIT
	 */
	class Contributors_Plugin_My_Exception extends \Exception {
		/**
		 * Original exception instance.
		 *
		 * @var Exception
		 */
		protected $original;
		/**
		 * Init function
		 *
		 * @param string    $msg error message.
		 * @param Exception $e Original exception instance.
		 */
		public function __construct( $msg, $e = null ) {
			$this->original = $e;
			parent::__construct( $msg );
		}
	}
}
