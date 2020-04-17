<?php
	/**
	 * @package     plgSystemVmCart\controllers
	 * @subpackage
	 *
	 * @copyright   A copyright
	 * @license     A "Slug" license name e.g. GPL2
	 */
	
//	namespace plgSystemVmCart\Controllers;
	
//	use VirtueMartControllerCart;
	
	defined ('JPATH_VM_SITE') or define('JPATH_VM_SITE', JPATH_SITE  . DS . 'components' . DS . 'com_virtuemart' );
	
	if (!class_exists('VmConfig')) {
		require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'helpers' . DS . 'config.php');
	}
	
	
	if (!class_exists('VirtueMartControllerCart')) require(JPATH_VM_SITE . DS . 'controllers' . DS . 'cart.php');
	if (!class_exists('VmView'))require(JPATH_VM_SITE.DS.'helpers'.DS.'vmview.php');
	class VirtueMartControllerCartOverride extends VirtueMartControllerCart
	{
		/**
		 * @var string
		 * @since version
		 */
		
		 
		public function __construct(  ){
			parent::__construct();
			
			$this->addViewPath( PLG_SYS_CART_PATH .'/views');
			$this->addPath('models', PLG_SYS_CART_PATH . '/models');
		}
		
		public function display($cachable = false, $urlparams = false){
			
			$viewLayout = vRequest::getCmd('layout', 'default');
			$view = $this->getView( 'cartoverride' ,   'html' , '', array('layout' => $viewLayout));
			
			parent::display( $cachable , $urlparams);
		}
		
	}