<?php
	/**
	 * @package     ${NAMESPACE}
	 * @subpackage
	 *
	 * @copyright   A copyright
	 * @license     A "Slug" license name e.g. GPL2
	 */
	class VirtueMartModelUserfieldsOverride extends VirtueMartModelUserfields {
		/**
		 * @var mixed
		 * @since version
		 */
		private static $plgParams;
		
		/**
		 * VirtueMartModelUserfieldsOverride constructor.
		 * @since 3.9
		 */
		function __construct() {
			parent::__construct();
			self::$plgParams = PlgCartSetting::getParams();
			
			
			
		}
		/**
		 * Вернуть массив с userFields в нескольких форматах.
		 *
		 * @access public
		 * @param $_selection An array, as returned by getuserFields(), with fields that should be returned.
		 * @param $_userData Array with userdata holding the values for the fields
		 * @param $_prefix string Optional prefix for the formtag name attribute
		 * @author Oscar van Eijk
		 * @return array List with all userfield data in the format:
		 * array(
		 *    'fields' => array(   // All fields
		 *                   <fieldname> => array(
		 *                                     'name' =>       // Name of the field
		 *                                     'value' =>      // Existing value for the current user, or the default
		 *                                     'title' =>      // Title used for label and such
		 *                                     'type' =>       // Field type as specified in the userfields table
		 *                                     'hidden' =>     // True/False
		 *                                     'required' =>   // True/False. If True, the formcode also has the class "required" for the Joomla formvalidator
		 *                                     'formcode' =>   // Full HTML tag
		 *                                  )
		 *                   [...]
		 *                )
		 *    'functions' => array() // Optional javascript functions without <script> tags.
		 *                           // Possible usage: if (count($ar('functions')>0) echo '<script ...>'.join("\n", $ar('functions')).'</script>;
		 *    'scripts'   => array(  // Array with scriptsources for use with JHtml::script();
		 *                      <name> => <path>
		 *                      [...]
		 *                   )
		 *    'links'     => array(  // Array with stylesheets for use with JHtml::stylesheet();
		 *                      <name> => <path>
		 *                      [...]
		 *                   )
		 * )
		 * @example This example illustrates the use of this function. For additional examples, see the Order view
		 * and the User view in the administrator section.
		 * <pre>
		 *   // In the controller, make sure this model is loaded.
		 *   // In view.html.php, make the following calls:
		 *   $_usrDetails = getUserDetailsFromSomeModel(); // retrieve an user_info record, eg from the usermodel or ordermodel
		 *   $_usrFieldList = $userFieldsModel->getUserFields(
		 *                    'registration'
		 *                  , array() // Default switches
		 *                  , array('delimiter_userinfo', 'username', 'email', 'password', 'password2', 'agreed', 'address_type') // Skips
		 *    );
		 *   $usrFieldValues = $userFieldsModel->getUserFieldsFilled(
		 *                      $_usrFieldList
		 *                     ,$_usrDetails
		 *   );
		 *   $this-userfields= $userfields;
		 *   // In the template, use code below to display the data. For an extended example using
		 *   // delimiters, JavaScripts and StyleSheets, see the edit_shopper.php in the user view
		 *   <table class="admintable" width="100%">
		 *     <thead>
		 *       <tr>
		 *         <td class="key" style="text-align: center;"  colspan="2">
		 *            <?php echo vmText::_('COM_VIRTUEMART_TABLE_HEADER') ?>
		 *         </td>
		 *       </tr>
		 *     </thead>
		 *      <?php
		 *        foreach ($this->shipmentfields['fields'] as $_field ) {
		 *          echo '  <tr>'."\n";
		 *          echo '    <td class="key">'."\n";
		 *          echo '      '.$_field['title']."\n";
		 *          echo '    </td>'."\n";
		 *          echo '    <td>'."\n";
		 *
		 *          echo '      '.$_field['value']."\n";    // Display only
		 *       Or:
		 *          echo '      '.$_field['formcode']."\n"; // Input form
		 *
		 *          echo '    </td>'."\n";
		 *          echo '  </tr>'."\n";
		 *        }
		 *      ?>
		 *    </table>
		 * </pre>
		 * @since 3.9
		 */
		public function getUserFieldsFilled($_selection, &$_userDataIn = null, $_prefix = '', $defaults = false){
			
			vmLanguage::loadJLang('com_virtuemart_shoppers',TRUE);
			
			//We copy the input data to prevent that objects become arrays
			if(empty($_userDataIn)){
				$_userData = array();
			} else {
				$_userData = $_userDataIn;
				$_userData=(array)($_userData);
			}
			
			$_return = array(
				'fields' => array()
			,'functions' => array()	//Why do we still have this?
			,'scripts' => array() //Why do we still have this?
			,'links' => array() //Why do we still have this?
			,'byDefault' => array()
			);
			
			$admin = vmAccess::manager();
			
			
			if (is_array($_selection)) {
				
				foreach ($_selection as $_fld) {
					
					$yOffset = 0;
					
					if(!empty($_userDataIn) and isset($_fld->default) and $_fld->default!=''){
						if(is_array($_userDataIn)){
							if(!isset($_userDataIn[$_fld->name])){
								$_userDataIn[$_fld->name] = $_fld->default;
								$_return['byDefault'][$_fld->name] = 1;
							}
						} else {
							if(!isset($_userDataIn->{$_fld->name})){
								$_userDataIn->{$_fld->name} = $_fld->default;
								$_return['byDefault'][$_fld->name] = 1;
							}
						}
					}
					
					if($_userData == null || !array_key_exists($_fld->name, $_userData)){
						
						if(empty($_fld->default)){
							$valueO = $valueN = $_fld->default;
						} else {
							$_return['byDefault'][$_fld->name] = 1;
							$valueO = $valueN = vmText::_($_fld->default);
						}
					} else {
						$valueO = $valueN = $_userData[$_fld->name];
					}
					
					
					//TODO htmlentites creates problems with non-ascii chars, which exists as htmlentity, for example äöü
					
					if ((!empty($valueN)) && (is_string($valueN))) $valueN = htmlspecialchars($valueN,ENT_COMPAT, 'UTF-8', false);	//was htmlentities
					
					$_return['fields'][$_fld->name] = array(
						'name' => $_prefix . $_fld->name
					,'value' => $valueN // htmlspecialchars (was htmlentities) encoded value for all except editorarea and plugins
					,'unescapedvalue'=> $valueO
					,'title' => vmText::_($_fld->title)
					,'type' => $_fld->type
					,'required' => $_fld->required
					,'hidden' => false
					,'formcode' => ''
					,'description' => vmText::_($_fld->description)
					,'register' => (isset($_fld->register)? $_fld->register:0)
					,'htmlentities' => true  // to provide version check agains previous versions
					);
					
					if($defaults and $_fld->name!='virtuemart_country_id' and $_fld->name!='virtuemart_state_id') continue;
					
					$placeholder = '';
					if( !empty($_fld->placeholder) ) $placeholder = 'placeholder="'.vmText::_($_fld->placeholder).'"';
					
					//Set the default on the data
					/*if(isset($_userData) and empty($_userData[$_fld->name]) and isset($_fld->default) and $_fld->default!='' ){
						$_userData[$_fld->name] = $_fld->default;
					}*/
					$readonly = '';
					if(!$admin){
						if($_fld->readonly ){
							$readonly = ' readonly="readonly" ';
						}
					}
					//vmdebug ('getUserFieldsFilled',$_fld->name,$_return['fields'][$_fld->name]['value']);
					// 			if($_fld->name==='email') vmdebug('user data email getuserfieldbyuser',$_userData);
					// First, see if there are predefined fields by checking the name
					
					
					
					switch( $_fld->name ) {
						
						
						
						// 				case 'email':
						// 					$_return['fields'][$_fld->name]['formcode'] = $_userData->email;
						// 					break;
						case 'virtuemart_country_id':
							
							$attrib = array();
							if ($_fld->size) {
								$attrib = array('style'=>"width: ".$_fld->size."px");
							}
							
							if(!$defaults) {
								$_return['fields'][$_fld->name]['formcode'] = ShopFunctionsF::renderCountryList($_return['fields'][$_fld->name]['value'], false, $attrib , $_prefix, $_fld->required,'virtuemart_country_id_field');
							}
							
							if(!empty($_return['fields'][$_fld->name]['value'])){
								// Translate the value from ID to name
								$_return['fields'][$_fld->name]['virtuemart_country_id'] = (int)$_return['fields'][$_fld->name]['value'];
								
								$countryT = $this->getTable('countries');
								$r = $countryT->load($_return['fields'][$_fld->name]['value'])->loadFieldValues();
								
								if($r){
									$_return['fields'][$_fld->name]['value'] = !empty($r['country_name'])? $r['country_name']:'' ;
									$_return['fields'][$_fld->name]['country_2_code'] = !empty($r['country_2_code'])? $r['country_2_code']:'' ;
									$_return['fields'][$_fld->name]['country_3_code'] = !empty($r['country_3_code'])? $r['country_3_code']:'' ;
									
									$lang = vmLanguage::getLanguage();
									$prefix="COM_VIRTUEMART_COUNTRY_";
									if( $lang->hasKey($prefix.$_return['fields'][$_fld->name]['country_3_code']) ){
										$_return['fields'][$_fld->name]['value'] = vmText::_($prefix.$_return['fields'][$_fld->name]['country_3_code']);
									}
								} else {
									vmError('Model Userfields, country with id '.$_return['fields'][$_fld->name]['value'].' not found');
								}
							} else {
								$_return['fields'][$_fld->name]['value'] = '' ;
								$_return['fields'][$_fld->name]['country_2_code'] = '' ;
								$_return['fields'][$_fld->name]['country_3_code'] = '' ;
							}
							
							//$_return['fields'][$_fld->name]['value'] = vmText::_(shopFunctions::getCountryByID($_return['fields'][$_fld->name]['value']));
							//$_return['fields'][$_fld->name]['state_2_code'] = vmText::_(shopFunctions::getCountryByID($_return['fields'][$_fld->name]['value']));
							break;
						
						case 'virtuemart_state_id':
							
							if(!$defaults) {
								$attrib = array();
								if ($_fld->size) {
									$attrib = array('style'=>"width: ".$_fld->size."px");
								}
								
								// $attrib['_required']= "required" ;
								
								$_return['fields'][$_fld->name]['formcode'] =
									shopFunctionsF::renderStateList(	$_return['fields'][$_fld->name]['value'],
										$_prefix,
										false,
										$_fld->required,
										$attrib,
										'virtuemart_state_id_field'
									);
							}
							
							if(!empty($_return['fields'][$_fld->name]['value'])){
								// Translate the value from ID to name
								$_return['fields'][$_fld->name]['virtuemart_state_id'] = (int)$_return['fields'][$_fld->name]['value'];
								$db = JFactory::getDBO ();
								$q = 'SELECT * FROM `#__virtuemart_states` WHERE virtuemart_state_id = "' . (int)$_return['fields'][$_fld->name]['value'] . '"';
								$db->setQuery ($q);
								$r = $db->loadAssoc();
								if($r){
									$_return['fields'][$_fld->name]['value'] = !empty($r['state_name'])? $r['state_name']:'' ;
									$_return['fields'][$_fld->name]['state_2_code'] = !empty($r['state_2_code'])? $r['state_2_code']:'' ;
									$_return['fields'][$_fld->name]['state_3_code'] = !empty($r['state_3_code'])? $r['state_3_code']:'' ;
								} else {
									vmError('Model Userfields, state with id '.$_return['fields'][$_fld->name]['value'].' not found');
								}
							} else {
								$_return['fields'][$_fld->name]['value'] = '' ;
								$_return['fields'][$_fld->name]['state_2_code'] = '' ;
								$_return['fields'][$_fld->name]['state_3_code'] = '' ;
							}
							
							//$_return['fields'][$_fld->name]['value'] = shopFunctions::getStateByID($_return['fields'][$_fld->name]['value']);
							break;
						//case 'agreed':
						//	$_return['fields'][$_fld->name]['formcode'] = '<input type="checkbox" id="'.$_prefix.'agreed_field" name="'.$_prefix.'agreed" value="1" '
						//		. ($_fld->required ? ' class="required"' : '') . ' />';
						//	break;
						case 'password':
						case 'password2':
							$req = $_fld->required ? 'required' : '';
						
						
							$class = 'class="validate-password '.$req.' inputbox"'
								. ($_fld->required ? ' _required="required"' : '')
							;
							
							$_return['fields'][$_fld->name]['formcode'] = '<input type="password" id="' . $_prefix.$_fld->name . '_field" name="' . $_prefix.$_fld->name .'" '.($_fld->required ? ' class="required"' : ''). ' size="30" '.$class.' '.$placeholder.' />'."\n";
							break;
							break;
							
							//case 'agreed':
							//case 'tos':
							
							
							break;
						
						case 'phone_2':
						case 'phone_1':
							
							$this->getPhoneMask( $_fld->name );
							$min_phone_number = self::$plgParams->get('min_phone_number' , 12 ) ;
							
							$_return[ 'fields' ][ $_fld->name ][ 'formcode' ] = '<input type="text" id="'
								. $_prefix . $_fld->name . '_field" name="' . $_prefix . $_fld->name . '" size="' . $_fld->size
								. '" value="' . $_return[ 'fields' ][ $_fld->name ][ 'value' ] . '" '
								. 'data-min_phone_number="'.$min_phone_number.'"'
								. 'class="'
								. 'input-text check-input-text'
								. ( $_fld->required ? ' required' : '' )
								. '"'
								
								. ($_fld->required ? ' _required="required"' : '')
								
								. ( $_fld->maxlength ? ' maxlength="' . $_fld->maxlength . '"' : '' )
								. $readonly . ' ' . $placeholder . ' /> ';
							break;
							
						// It's not a predefined field, so handle it by it's fieldtype
						default:
							if(strpos($_fld->type,'plugin')!==false){
								
								VmConfig::importVMPlugins('vmuserfield');
								$dispatcher = JDispatcher::getInstance();
								
								$_return['fields'][$_fld->name]['value'] = $_return['fields'][$_fld->name]['unescapedvalue'];
								$_return['fields'][$_fld->name]['htmlentities'] = false;
								$dispatcher->trigger('plgVmOnUserfieldDisplay',array($_prefix, $_fld,isset($_userData['virtuemart_user_id'])?$_userData['virtuemart_user_id']:0,  &$_return) );
								break;
							}
							switch( $_fld->type ) {
								case 'hidden':
									$_return['fields'][$_fld->name]['formcode'] = '<input type="hidden" id="'
										. $_prefix.$_fld->name . '_field" name="' . $_prefix.$_fld->name.'" size="' . $_fld->size
										. '" value="' . $_return['fields'][$_fld->name]['value'] .'" '
										. ($_fld->required ? ' class="required"' : '')
										
										. ($_fld->required ? ' _required="required"' : '')
										
										
										. ($_fld->maxlength ? ' maxlength="' . $_fld->maxlength . '"' : '')
										. $readonly . ' /> ';
									$_return['fields'][$_fld->name]['hidden'] = true;
									break;
								case 'age_verification':
									// Year range MUST start 100 years ago, for birthday
									$currentYear = intval(date('Y'));
									$yOffset = 120;
									$maxmin = 'minDate: "-'.$yOffset.'y", maxDate: "+'.$yOffset.'Y",';
								case 'date':
									$currentYear = intval(date('Y'));
									if(empty($maxmin))$maxmin = 'minDate: -0, maxDate: "+1Y",';
									$_return['fields'][$_fld->name]['formcode'] = vmJsApi::jDate($_return['fields'][$_fld->name]['value'],  $_prefix.$_fld->name,$_prefix.$_fld->name . '_field',false,($currentYear-$yOffset).':'.($currentYear+1),$maxmin);
									
									$maxmin = '';
									break;
								case 'emailaddress':
									if( JFactory::getApplication()->isSite()) {
										if(empty($_return['fields'][$_fld->name]['value']) && $_fld->required) {
											$_return['fields'][$_fld->name]['value'] = JFactory::getUser()->email;
										}
										
										$email_no_required = self::$plgParams->get('email_no_required' , false ) ;
										$email_info = self::$plgParams->get('email_info' , false ) ;
										$email_no_autocomplete = self::$plgParams->get('email_no_autocomplete' , false ) ;
										
										if( $email_no_required )
										{
											$_fld->required = false ;
											$_return['fields'][$_fld->name]['required']= false ;
										}#END IF
										
										if( $email_no_autocomplete )
										{
											$autocomplete = ' autocomplete="off" ';
										}#END IF
										
 									    $_return['fields'][$_fld->name]['formcode'] = '<input type="email" id="'
											. $_prefix.$_fld->name . '_field" name="' . $_prefix.$_fld->name.'" size="' . $_fld->size
											. '" value="' . $_return['fields'][$_fld->name]['value'] .'" '
											. $autocomplete
											.'class="'
											. 'input-text check-input-text validate-email'
											. ($_fld->required ? ' required' : '')
											.'"'
											. ($_fld->required ? ' _required="required"' : '')
											
											
											// . ($_fld->required ? ' class="required validate-email"' : '')
											. ($_fld->maxlength ? ' maxlength="' . $_fld->maxlength . '"' : '')
											. $readonly . '  '.$placeholder.' /> ';
										
										if( $email_info )
										{
											$_return['fields'][$_fld->name]['formcode'] .=
												'<p class="f-i-sign" name="email_info">'.JText::_($email_info).'</p>' ;
										}#END IF
										
										break;
									}
								
								case 'text':
								case 'webaddress':
									
									$_return['fields'][$_fld->name]['formcode'] = '<input type="text" id="'
										. $_prefix.$_fld->name . '_field" name="' . $_prefix.$_fld->name.'" size="' . $_fld->size
										. '" value="' . $_return['fields'][$_fld->name]['value'] .'" '
										
										.'class="'
											. 'input-text check-input-text'
											. ($_fld->required ? ' required' : '')
										.'"'
										
										. ($_fld->required ? ' _required="required"' : '')
										
										. ($_fld->maxlength ? ' maxlength="' . $_fld->maxlength . '"' : '')
										. $readonly . ' '.$placeholder.' /> ';
									
									
									
									break;
									
								case 'textarea':
									$_return['fields'][$_fld->name]['formcode'] = '<textarea id="'
										. $_prefix.$_fld->name . '_field" name="' . $_prefix.$_fld->name . '" cols="' . $_fld->cols
										. '" rows="'.$_fld->rows
										. '" class="inputbox'
											.($_fld->required ? ' required': '' )
										.'" '
										. ($_fld->required ? ' _required="required"' : '')
										
										
										. ($_fld->maxlength ? ' maxlength="' . $_fld->maxlength . '"' : '')
										. $readonly.' '.$placeholder.' >'
										. $_return['fields'][$_fld->name]['value'] .'</textarea>';
									break;
								case 'editorta':
									jimport( 'joomla.html.editor' );
									$editor = JFactory::getEditor();
									
									$_return['fields'][$_fld->name]['value'] = $_return['fields'][$_fld->name]['unescapedvalue'];
									$_return['fields'][$_fld->name]['htmlentities'] = false;
									$_return['fields'][$_fld->name]['formcode'] = $editor->display($_prefix.$_fld->name,$_return['fields'][$_fld->name]['value'], '150', '100', $_fld->cols, $_fld->rows,  array('pagebreak', 'readmore'));
									break;
								case 'checkbox':
									$_return['fields'][$_fld->name]['formcode'] = '<input type="checkbox" name="'
										. $_prefix.$_fld->name . '" id="' . $_prefix.$_fld->name . '_field" value="1" '
										. ($_return['fields'][$_fld->name]['value'] ? 'checked="checked"' : '')
										
										. ($_fld->required ? ' class="required"' : '')
										. ($_fld->required ? ' _required="required"' : '')
										
										.' />';
									if($_return['fields'][$_fld->name]['value']) {
										$_return['fields'][$_fld->name]['value'] = vmText::_($_prefix.$_fld->title);
									}
									break;
								case 'custom':
									
									$_return['fields'][$_fld->name]['value'] = $_return['fields'][$_fld->name]['unescapedvalue'];
									$_return['fields'][$_fld->name]['htmlentities'] = false;
									$_return['fields'][$_fld->name]['formcode'] =  shopFunctionsF::renderVmSubLayout($_fld->name,array('field'=>$_return['fields'][$_fld->name],'userData' => $_userData,'prefix' => $_prefix));
									break;
								// /*##mygruz20120223193710 { :*/
								// case 'userfieldplugin': //why not just vmuserfieldsplugin ?
								// JPluginHelper::importPlugin('vmuserfield');
								// $dispatcher = JDispatcher::getInstance();
								// //Todo to adjust to new pattern, using &
								// $html = '' ;
								// $dispatcher->trigger('plgVmOnUserFieldDisplay',array($_return['fields'][$_fld->name], &$html) );
								// $_return['fields'][$_fld->name]['formcode'] = $html;
								// break;
								// /*##mygruz20120223193710 } */
								case 'multicheckbox':
								case 'multiselect':
								case 'select':
								case 'radio':
									$_qry = 'SELECT `fieldtitle`, `fieldvalue` '
										. 'FROM `#__virtuemart_userfield_values` '
										. 'WHERE `virtuemart_userfield_id` = ' . (int)$_fld->virtuemart_userfield_id
										. ' ORDER BY `ordering` ';
									$_values = $this->_getList($_qry);
									// We need an extra lok here, especially for the Bank info; the values
									// must be translated.
									// Don't check on the field name though, since others might be added in the future :-(
									
									foreach ($_values as $_v) {
										$_v->fieldtitle = vmText::_($_v->fieldtitle);
									}
									
									$_attribs = array();
									if ($_fld->readonly and !$admin) {
										$_attribs['readonly'] = 'readonly';
									}
									
									
									if ($_fld->required) {
										if(!isset($_attribs['class'])){
											$_attribs['class'] = '';
										}
										$_attribs['class'] .= ' required';
										$_attribs['_required']  = 'required';
										
									}
								
									if ($_fld->type == 'radio' or $_fld->type == 'select') {
										$_selected = $_return['fields'][$_fld->name]['value'];
									} else {
										$_attribs['size'] = $_fld->size; // Use for all but radioselects
										if (!is_array($_return['fields'][$_fld->name]['value'])){
											$_selected = explode("|*|", $_return['fields'][$_fld->name]['value']);
										} else {
											$_selected = $_return['fields'][$_fld->name]['value'];
										}
									}
									
									// Nested switch...
									switch($_fld->type) {
										case 'multicheckbox':
											
											// todo: use those
											$_attribs['rows'] = $_fld->rows;
											$_attribs['cols'] = $_fld->cols;
											$formcode = '';
											$field_values="";
											$_idx = 0;
											$separator_form = '<br />';
											$separator_title = ',';
											foreach ($_values as $_val) {
												if ( in_array($_val->fieldvalue, $_selected)) {
													$is_selected='checked="checked"';
													$field_values.= vmText::_($_val->fieldtitle). $separator_title;
												}  else {
													$is_selected='';
												}
												$formcode .= '<input type="checkbox" name="'
													. $_prefix.$_fld->name . '[]" id="' . $_prefix.$_fld->name . '_field' . $_idx . '" value="'. $_val->fieldvalue . '" '
													. $is_selected .'/> <label for="' . $_prefix.$_fld->name . '_field' . $_idx . '">'.vmText::_($_val->fieldtitle) .'</label>'. $separator_form;
												$_idx++;
												
												
												
											}
											// remove last br
											$_return['fields'][$_fld->name]['formcode'] =substr($formcode ,0,-strlen($separator_form));
											$_return['fields'][$_fld->name]['value'] = substr($field_values,0,-strlen($separator_title));
											break;
										case 'multiselect':
											$_attribs['multiple'] = 'multiple';
											if(!isset($_attribs['class'])){
												$_attribs['class'] = '';
												
											}
											$_attribs['_required'] = 'required';
											
											$_attribs['class'] .= ' vm-chzn-select';
											$field_values="";
											$_return['fields'][$_fld->name]['formcode'] = JHtml::_('select.genericlist', $_values, $_prefix.$_fld->name.'[]', $_attribs, 'fieldvalue', 'fieldtitle', $_selected);
											$separator_form = '<br />';
											$separator_title = ',';
											foreach ($_values as $_val) {
												if ( in_array($_val->fieldvalue, $_selected)) {
													$field_values.= vmText::_($_val->fieldtitle). $separator_title;
												}
											}
											$_return['fields'][$_fld->name]['value'] = substr($field_values,0,-strlen($separator_title));
											
											break;
										case 'select':
											if(!isset($_attribs['class'])){
												$_attribs['class'] = '';
											}
											$_attribs['class'] .= ' vm-chzn-select';
											if ($_fld->size) {
												$_attribs['style']= "width: ".$_fld->size."px";
											}
											if(!$_fld->required){
												$obj = new stdClass();
												$obj->fieldtitle = vmText::_('COM_VIRTUEMART_LIST_EMPTY_OPTION');
												$obj->fieldvalue = '';
												array_unshift($_values,$obj);
												
												$_attribs['_required']= "required" ;
												
											}
											
											$_return['fields'][$_fld->name]['formcode'] = JHTML::_('select.genericlist', $_values, $_prefix.$_fld->name, $_attribs, 'fieldvalue', 'fieldtitle', $_selected,$_prefix.$_fld->name.'_field');
											if ( !empty($_selected)){
												foreach ($_values as $_val) {
													if ( $_val->fieldvalue==$_selected ) {
														// vmdebug('getUserFieldsFilled set empty select to value',$_selected,$_fld,$_return['fields'][$_fld->name]);
														$_return['fields'][$_fld->name]['value'] = vmText::_($_val->fieldtitle);
													}
												}
											}
											
											break;
										case 'radio':
											
											
											$_return['fields'][$_fld->name]['formcode'] =  JHtml::_('select.radiolist', $_values, $_prefix.$_fld->name, $_attribs, 'fieldvalue', 'fieldtitle', $_selected, $_prefix.$_fld->name.'_field');
											if ( !empty($_selected)){
												foreach ($_values as $_val) {
													if (  $_val->fieldvalue==$_selected) {
														$_return['fields'][$_fld->name]['value'] = vmText::_($_val->fieldtitle);
													}
												}
											}
											
											break;
									}
									break;
							}
							break;
					}
				}
			} else {
				vmdebug('getUserFieldsFilled $_selection is not an array ',$_selection);
// 			$_return['fields'][$_fld->name]['formcode'] = '';
			}
			
			return $_return;
		}
		
		/**
		 * Установщик масок телефонов
		 * @param $name - Знечение атребута name=""
		 * @since 3.9
		 */
		private function getPhoneMask( $name ){
			$phone_mask = self::$plgParams->get('phone_mask' , false ) ;
			$phoneMaskLoad = self::$plgParams->get('phoneMaskLoad' , false ) ;
			if( !$phone_mask ) return ; #END IF
			
			$doc = JFactory::getDocument();
			
			$Mask = $doc->getScriptOptions('MaskCart') ;
			$Mask['mask_elements'][$name] = [
				'name' =>  $name ,
			];
			$doc->addScriptOptions('MaskCart' , $Mask ) ;
			
			if( $phoneMaskLoad ) return ; #END IF
			
			$Jpro = $doc->getScriptOptions('Jpro' , [ 'load'=>[] ]) ;
			$Jpro['load'][] = [
				'u' => '/plugins/system/plg_system_vm_cart/assets/js/PlgCart.Phone.js' ,
				't' => 'js' ,
				'c' => '' ,
			];
			$doc->addScriptOptions('Jpro' , $Jpro ) ;
			self::$plgParams->get('phoneMaskLoad' , true  ) ;
		}
		
	}