<?php
	/**
	 * @package     ${NAMESPACE}
	 * @subpackage
	 *
	 * @copyright   A copyright
	 * @license     A "Slug" license name e.g. GPL2
	 */
	if( !class_exists( 'VmView' ) )
		require( JPATH_VM_SITE . DS . 'helpers' . DS . 'vmview.php' );
	
	class VirtueMartViewCartOverride extends VmView
	{
		/**
		 * @var JLayout
		 * @since version
		 */
		public $rendererLayout;
		
		/*** OVERRIDE ***/
		
		public function __construct ( $config = array() )
		{
			$config[ 'base_path' ] = PLG_SYS_CART_PATH;
			parent::__construct( $config );
			
			$this->app = JFactory::getApplication();
			
			JLoader::register( 'VirtueMartModelUserOverride', JPATH_PLUGINS . '/system/plg_system_vm_cart/models/userOverride.php' );
		}
		
		/**
		 * Указать какие поля добавлять в заголовок контактных данных
		 *
		 * @since version
		 */
		private static function userfields_in_title(){
			$plgParams = PlgCartSetting::getParams();
			$userfields_in_title = $plgParams->get('userfields_in_title' , [] ) ;
			$doc = JFactory::getDocument();
			$doc->addScriptOptions('userfields_in_title' , $userfields_in_title ) ;
		}
		
		/**
		 * Добавить пользовательские стили в  Head
		 *
		 * @since version
		 */
		private static function addStyleSetting(){
			$plgParams = PlgCartSetting::getParams();
			$add_stile = $plgParams->get('add_stile' , false ) ;
			if( !$add_stile ) return ; #END IF
			$doc = JFactory::getDocument();
			$doc->addStyleDeclaration( $add_stile ) ;
		}
		
		public function display ( $tpl = null )
		{
			
			$this->useSSL = vmURI::useSSL();
			$this->useXHTML = false;
			
			$doc = JFactory::getDocument();
			$doc->setMetaData('robots','NOINDEX, NOFOLLOW, NOARCHIVE, NOSNIPPET');
			
			vmLanguage::loadJLang( 'com_virtuemart_shoppers', true );
			
			$this->_model = VmModel::getModel( 'UserOverride' );
			
			$this->cart = VirtueMartCart::getCart();
			$this->cart->prepareVendor();
			
			# Добавить пользовательские стили в  Head
			self::addStyleSetting();
			#Указать какие поля добавлять в заголовок контактных данных
			self::userfields_in_title();
			
			$pathway = $this->app->getPathway();
			$layoutName = $this->getLayout();
			
			# параметры плагина
			$this->plg_system_vm_cart_params = $this->app->input->get( 'plg_system_vm_cart_params', false, 'ARRAY' );
			
			# Установка параметров Layout
			$this->rendererLayout = $this->getRenderer( 'LayoutName'  );
			
			
			// $this->setLayout($layoutName);

//			$layoutName->setLayout('cron');
//			echo'<pre>';print_r( $layoutName );echo'</pre>'.__FILE__.' '.__LINE__;
//			die(__FILE__ .' '. __LINE__ );
			
			$editor = JFactory::getEditor();
			
			$virtuemart_user_id = vRequest::getInt( 'virtuemart_user_id', false );
			
			if( $virtuemart_user_id and is_array( $virtuemart_user_id ) ){
				$virtuemart_user_id = $virtuemart_user_id[ 0 ];
			}
			
			$this->_model->setId( $virtuemart_user_id );
			# данные покупателя
			$this->userDetails = $this->_model->getUser();
			
			$this->address_type = vRequest::getCmd( 'addrtype', 'BT' );
			
			
			$new = false;
			if( vRequest::getInt( 'new', '0' ) == 1 )
			{
				$new = true;
			}
			
			if( $new )
			{
				$virtuemart_userinfo_id = 0;
			} else
			{
				$virtuemart_userinfo_id = vRequest::getString( 'virtuemart_userinfo_id', 0 );
			}
			
			$userFields = null;
			
			$task = vRequest::getCmd( 'task', '' );
			if( $task == 'addST' )
			{
				$this->address_type = 'ST';
			}
			
			
			
			if( ( $this->cart->_fromCart or $this->cart->getInCheckOut() ) or ( $new and empty( $virtuemart_userinfo_id ) ) )
			{
				
				//New Address is filled here with the data of the cart (we are in the cart)
				$fieldtype = $this->address_type . 'address';
				$this->cart->setupAddressFieldsForCart( true );
				$userFields = $this->cart->{$fieldtype};
				
			}
			else
			{
				if( !$new and empty( $virtuemart_userinfo_id ) )
				{
					$virtuemart_userinfo_id = $this->_model->getBTuserinfo_id();
					vmdebug( 'Try to get $virtuemart_userinfo_id by type BT', $virtuemart_userinfo_id );
				}
				
				$userFields = $this->_model->getUserInfoInUserFields( $layoutName, $this->address_type, $virtuemart_userinfo_id, false );
				
			 
				
				if( !$new && empty( $userFields[ $virtuemart_userinfo_id ] ) )
				{
					$virtuemart_userinfo_id = $this->_model->getBTuserinfo_id();
					vmdebug( '$userFields by getBTuserinfo_id', $userFields );
				}
				
				$userFields = $userFields[ $virtuemart_userinfo_id ];
			}
			
			
			$this->virtuemart_userinfo_id = $virtuemart_userinfo_id;
			
			$this->assignRef( 'userFields', $userFields );
			
			
			$this->currencyDisplay = CurrencyDisplay::getInstance($this->cart->pricesCurrency);
			
			$this->cart->prepareCartData();
			$this->lSelectShipment();
			
			parent::display( $tpl );
		}
		
		/**
		 * lSelectShipment
		 * find al shipment rates available for this cart
		 *
		 * @author Valerie Isaksen
		 */
		private function lSelectShipment() {
			$found_shipment_method=false;
			$shipment_not_found_text = vmText::_('COM_VIRTUEMART_CART_NO_SHIPPING_METHOD_PUBLIC');
			$this->assignRef('shipment_not_found_text', $shipment_not_found_text);
			$this->assignRef('found_shipment_method', $found_shipment_method);
			
			$shipments_shipment_rates=array();
			if (!$this->checkShipmentMethodsConfigured()) {
				$this->assignRef('shipments_shipment_rates',$shipments_shipment_rates);
				return;
			}
			
			$selectedShipment = (empty($this->cart->virtuemart_shipmentmethod_id) ? 0 : $this->cart->virtuemart_shipmentmethod_id);
			
			$shipments_shipment_rates = array();
			
			//JPluginHelper::importPlugin('vmshipment');
			$dispatcher = JDispatcher::getInstance();
			
			$d = VmConfig::$_debug;
			if(VmConfig::get('debug_enable_methods',false)){
				VmConfig::$_debug = 1;
			}
			$returnValues = $dispatcher->trigger('plgVmDisplayListFEShipment', array( $this->cart, $selectedShipment, &$shipments_shipment_rates));
			VmConfig::$_debug = $d;
			// if no shipment rate defined
			$found_shipment_method =count($shipments_shipment_rates);
			
			$ok = true;
			if ($found_shipment_method == 0)  {
				$validUserDataBT = $this->cart->validateUserData();
				
				if ($validUserDataBT===-1) {
					if (VmConfig::get('oncheckout_opc', 1)) {
						vmdebug('lSelectShipment $found_shipment_method === 0 show error');
						$ok = false;
					} else {
						$mainframe = JFactory::getApplication();
						$mainframe->redirect(JRoute::_('index.php?option=com_virtuemart&view=user&task=editaddresscart&addrtype=BT'), vmText::_('COM_VIRTUEMART_CART_ENTER_ADDRESS_FIRST'));
					}
				}
				
			}
			
			$shipment_not_found_text = vmText::_('COM_VIRTUEMART_CART_NO_SHIPPING_METHOD_PUBLIC');
			$this->assignRef('shipment_not_found_text', $shipment_not_found_text);
			$this->assignRef('shipments_shipment_rates', $shipments_shipment_rates);
			$this->assignRef('found_shipment_method', $found_shipment_method);
			
			return $ok;
		}
		
		
		private function checkShipmentMethodsConfigured() {
			
			if ($this->cart->virtuemart_shipmentmethod_id) return true;
			
			//For the selection of the shipment method we need the total amount to pay.
			$shipmentModel = VmModel::getModel('Shipmentmethod');
			$shipments = $shipmentModel->getShipments();
			if (empty($shipments)) {
				
				$text = '';
				$user = JFactory::getUser();
				if(vmAccess::manager() or vmAccess::isSuperVendor()) {
					$uri = JFactory::getURI();
					$link = $uri->root() . 'administrator/index.php?option=com_virtuemart&view=shipmentmethod';
					$text = vmText::sprintf('COM_VIRTUEMART_NO_SHIPPING_METHODS_CONFIGURED_LINK', '<a href="' . $link . '" rel="nofollow">' . $link . '</a>');
				}
				
				vmInfo('COM_VIRTUEMART_NO_SHIPPING_METHODS_CONFIGURED', $text);
				
				$tmp = 0;
				$this->assignRef('found_shipment_method', $tmp);
				$this->cart->virtuemart_shipmentmethod_id = 0;
				return false;
			}
			return true;
		}
		
		
		
		
		
		// add vendor for cart
		function prepareVendor(){
			
			$vendorModel = VmModel::getModel('vendor');
			$vendor =  $vendorModel->getVendor();
			$this->assignRef('vendor', $vendor);
			$vendorModel->addImages($this->vendor,1);
		}
		
		/**
		 * Get the plugin renderer
		 *
		 * @param string $layoutId Layout identifier
		 *
		 * @return  JLayout
		 *
		 * @throws Exception
		 * @since   3.5
		 */
		protected function getRenderer ( $layoutId = 'default' )
		{
			$renderer = new JLayoutFile( $layoutId );
			$renderer->setIncludePaths( $this->getLayoutPaths() );
			return $renderer;
		}
		
		/**
		 * Get the layout paths
		 *
		 * @return  array
		 *
		 * @throws Exception
		 * @since 3.9
		 */
		protected function getLayoutPaths ()
		{
			$template = JFactory::getApplication()->getTemplate();
			
			return array(
				JPATH_SITE . '/templates/' . $template . '/html/layouts/plg_system_vm_cart',
				PLG_SYS_CART_PATH . '/layouts',
			);
		}
	}
	