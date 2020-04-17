<?php
	/**
	 * @package     ${NAMESPACE}
	 * @subpackage
	 *
	 * @copyright   A copyright
	 * @license     A "Slug" license name e.g. GPL2
	 */
	defined('JPATH_BASE') or die;
	
	if (!class_exists('VmConfig'))
		require(JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . 'com_virtuemart' . DS . 'helpers' . DS . 'config.php');
	VmConfig::loadConfig();
 
	
	jimport('joomla.form.formfield');
	
	class JFormFieldVm_userfields extends JFormFieldList
	{
		protected $type = 'vm_userfields';
		
		protected function getOptions()
		{
			$app = \JFactory::getApplication() ;
			$userFieldsModel = VmModel::getModel('Userfields');
			$options = array();
			$_userFieldsBT = $userFieldsModel->getUserFields('account'
				, array('delimiters'=>true, 'captcha'=>true)
				, array('username','address_type', 'password', 'password2', 'user_is_vendor')
			);
			$userFieldsCart = $userFieldsModel->getUserFields(
				'cart'
				, array('captcha' => true, 'delimiters' => true) // Ignore these types
				, array('user_is_vendor'  ,'address_type','customer_note','tos' ,'username','password', 'password2', 'agreed', 'address_type') // Skips
			);
			
			$_userFieldsBT = array_merge($_userFieldsBT,$userFieldsCart);
			
			if( !count( $_userFieldsBT ) )
			{
				$app->enqueueMessage(JText::_('PLG_SYSTEM_VM_CART_VM_USERFIELDS_NOT_FOUND') , 'warning');
				return $options ;
			}#END IF
			
//			$options[] = JHtml::_('select.option', '', 'Select an option');
			foreach($_userFieldsBT as $item)
			{
				$text = JText::_($item->title) . '('.$item->name.')' ;
				$options[] = JHtml::_('select.option', $item->name, $text  );
			}
			
			return $options;
			
//			echo'<pre>';print_r( $userFieldsCart );echo'</pre>'.__FILE__.' '.__LINE__;
//			die(__FILE__ .' '. __LINE__ );
		}
		
	}