<?php

/**
 * Class for handle plugins exception
 *
 * PHP version 7.2.1
 *
 * @package  Exception
 * @author   Evgeniy S.Zalevskiy <2600@ukr.net>
 * @license  MIT
 */

if ( ! class_exists( 'Contributors_Plugin_My_Exception' ) ) {

	class Contributors_Plugin_My_Exception extends \Exception {

		protected $original;
		public function __construct( $msg, $e = null ) {
			$this->original = $e;
			parent::__construct( $msg );
		}
	}
}
