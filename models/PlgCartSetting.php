<?php
	/**
	 * @package     ${NAMESPACE}
	 * @subpackage
	 *
	 * @copyright   A copyright
	 * @license     A "Slug" license name e.g. GPL2
	 */
	
	class PlgCartSetting
	{
		private $app;
		public static $instance;
		public static $params;
		
		/**
		 * helper constructor.
		 *
		 * @throws \Exception
		 * @since 3.9
		 */
		private function __construct ( $options = array() )
		{
			
			return $this;
		}#END FN
		
		/**
		 * @param array $options
		 *
		 * @return helper
		 * @throws \Exception
		 * @since 3.9
		 */
		public static function instance ( $options = array() )
		{
			if( self::$instance === null )
			{
				self::$instance = new self( $options );
			}
			return self::$instance;
		}
		
		/**
		 * @return mixed
		 */
		public static function getParams ()
		{
			return self::$params;
		}
		
		/**
		 * @param mixed $params
		 */
		public static function setParams ( $params )
		{
			self::$params = $params;
		}#END FN
		
		
		
	}