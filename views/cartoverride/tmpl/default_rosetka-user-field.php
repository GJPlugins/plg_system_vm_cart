<?php
	/**
	 * @package     ${NAMESPACE}
	 * @subpackage
	 *
	 * @copyright   A copyright
	 * @license     A "Slug" license name e.g. GPL2
	 */
	defined('_JEXEC') or die;
	
	$this->rendererLayout->setLayout( 'user-field-div') ;
 
	
	
	foreach($this->userFields['fields'] as $field) {
		
		if($field['type'] == 'delimiter')  continue ;
		
		if($field['name']=='delimiter_userinfo') continue ;
		
		echo $this->rendererLayout->render(['field'=>$field]) ;
		
	}