<?php
/**
 * @package    e-lektra.com.ua
 *
 * @author     oleg <your@email.com>
 * @copyright  A copyright
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       http://your.url.com
 */

use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\Database\DatabaseDriver;

defined('_JEXEC') or die;
	
	define('PLG_SYS_CART_PATH', dirname(__FILE__));
	defined('DS') or define('DS', DIRECTORY_SEPARATOR);

/**
 * Plg_system_vm_cart plugin.
 *
 * @package   e-lektra.com.ua
 * @since     1.0.0
 */
class plgSystemPlg_system_vm_cart extends CMSPlugin
{
	/**
	 * Application object
	 *
	 * @var    CMSApplication
	 * @since  1.0.0
	 */
	protected $app;

	/**
	 * Database object
	 *
	 * @var    DatabaseDriver
	 * @since  1.0.0
	 */
	protected $db;

	/**
	 * Affects constructor behavior. If true, language files will be loaded automatically.
	 *
	 * @var    boolean
	 * @since  1.0.0
	 */
	protected $autoloadLanguage = true;
	
	public function __construct(&$subject, $config = array())
	{
		parent::__construct($subject, $config);
		$doc = JFactory::getDocument();
		JLoader::register( 'PlgCartSetting', JPATH_PLUGINS . '/system/plg_system_vm_cart/models/PlgCartSetting.php' );
		
		JLoader::registerNamespace('GNZ11',JPATH_LIBRARIES.'/GNZ11',$reset=false,$prepend=false,$type='psr4');
		$GNZ11_Js  = GNZ11\Core\Js::instance();
		
		$Jpro = $doc->getScriptOptions('Jpro' , [ 'load'=>[] ]) ;
		$Jpro['load'][] = [
			'u' => '/plugins/system/plg_system_vm_cart/assets/js/PlgCart.Core.js' ,
			't' => 'js' ,
			'c' => '' ,
		];
		$doc->addScriptOptions('Jpro' , $Jpro ) ;
		
 
	}
	
	
	
	
	/**
	 * onAfterInitialise.
	 *
	 * @return  void
	 *
	 * @since   1.0.0
	 */
	public function onAfterInitialise()
	{
		
	}

	/**
	 * onAfterRoute.
	 *
	 * @return  void
	 *
	 * @since   1.0.0
	 */
	public function onAfterRoute(){
		
		$app = JFactory::getApplication();
		$router = $app->getRouter();
		
		$option  = $app->input->get( 'option', false, 'RAW' );
		$view  = $app->input->get( 'view', false, 'RAW' );
		$task  = $app->input->get( 'task', false, 'RAW' );
		
		
		// Component Virtuemart
		if ($router->getVar('option') == 'com_virtuemart' || $option == 'com_virtuemart') {
			
			// Load VmConfig
			if (!class_exists('VmConfig')) {
				require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'helpers' . DS . 'config.php');
			}
			VmConfig::loadConfig();
			
			
			
			switch ($view) {
				// View Cart
				case 'cart':
					
					
					if(  $task != 'addJS' )
					{
						// We set manually ItemId for correct function of JModuleHelper Class
						$menus     = $app->getMenu( 'site' );
						$component = JComponentHelper::getComponent( 'com_virtuemart' );
						$items     = $menus->getItems( 'component_id' , $component->id );
						
						require_once(PLG_SYS_CART_PATH . DS . 'controllers' . DS . $view . 'Override.php' );
						$app->input->set('view' , $view. 'Override' );
						
						
						# Передача перамаметров в плагин
						$registry = new JRegistry();
						
						$registry->loadString( $this->params );
						
						PlgCartSetting::setParams( $this->params );
						
						$params = $registry->toArray();
						$app->input->set('plg_system_vm_cart_params' , $params );
						
						
						
						
						foreach( $items as $item )
						{
							if( isset( $item->query , $item->query[ 'view' ] ) )
							{
								if( $item->query[ 'view' ] === 'cart' )
								{
									$app->input->set( 'Itemid' , $item->id  );
									break;
								}#END IF
							}#END IF
						}
					}#END IF
				
				// Plugin
				// case 'plugin':
				// Plugin Response
				case 'vmplg':
				case 'pluginresponse':
					// If OPC Enabled
					if (VmConfig::get('oncheckout_opc', 1) == 1) {
					
						// Закрываем редактироване способов доставки и оплаты
						if ( $task === 'editpayment' || $task === 'edit_shipment') {
							echo'<pre>';print_r( $task );echo'</pre>'.__FILE__.' '.__LINE__;
							die(__FILE__ .' '. __LINE__ );
							$app->redirect(JRoute::_('index.php?option=com_virtuemart&view=cart', FALSE));
							// $this->redirectToCart_byPV();
                        }
						
						// Load default language
						$extension = strtolower('plg_' . $this->_type . '_' . $this->_name);
						$lang = JFactory::getLanguage();
						
						$langTag = $lang->getTag(); //example output format: en-GB
						$lang->load($extension, JPATH_PLUGINS . '/' . $this->_type . '/' . $this->_name , $langTag , false , false );
						
						// Load custom language (method is in JPlugin Class)
						$this->loadLanguage($extension, JPATH_SITE);
					}
					break;
				// View User
				case 'user':
					if ( $task === 'editaddresscheckout') {
						echo'<pre>';print_r( $task );echo'</pre>'.__FILE__.' '.__LINE__;
						die(__FILE__ .' '. __LINE__ );
						$app->redirect(JRoute::_('index.php?option=com_virtuemart&view=cart', FALSE));
					}
					break;
			}
		}
	}

	/**
	 * onAfterDispatch.
	 *
	 * @return  void
	 *
	 * @since   1.0.0
	 */
	public function onAfterDispatch()
	{
	
	}

	/**
	 * onAfterRender.
	 *
	 * @return  void
	 *
	 * @since   1.0.0
	 */
	public function onAfterRender()
	{
		// Access to plugin parameters
		$sample = $this->params->get('sample', '42');
	}

	/**
	 * onAfterCompileHead.
	 *
	 * @return  void
	 *
	 * @since   1.0.0
	 */
	public function onAfterCompileHead()
	{
	
	}

	/**
	 * OnAfterCompress.
	 *
	 * @return  void
	 *
	 * @since   1.0.0
	 */
	public function onAfterCompress()
	{
	
	}

	/**
	 * onAfterRespond.
	 *
	 * @return  void
	 *
	 * @since   1.0.0
	 */
	public function onAfterRespond()
	{
	
	}
}
