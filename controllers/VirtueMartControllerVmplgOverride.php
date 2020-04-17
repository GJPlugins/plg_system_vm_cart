<?php
	/**
	 * @package     plgSystemVmCart\controllers
	 * @subpackage
	 *
	 * @copyright   A copyright
	 * @license     A "Slug" license name e.g. GPL2
	 */
	
	namespace plgSystemVmCart\Controllers;
	
	use VirtueMartControllerVmplg;
	
	if (!class_exists('VirtueMartControllerVmplg')) require(JPATH_VM_SITE . DS . 'controllers' . DS . 'vmplg.php');
	
	
	class VirtueMartControllerVmplgOverride extends VirtueMartControllerVmplg
	{
		/*** OVERRIDE ***/
		/**
		 * VirtueMartController constructor.
		 *
		 * @param array $config
		 * @since 3.9
		 */
		public function __construct($config = array())
		{
			parent::__construct();
			$basePath = JPATH_PLUGINS .'/system/plg_system_vm_cart' ;
			$this->setPath('view', $basePath . '/views');
		}
	}