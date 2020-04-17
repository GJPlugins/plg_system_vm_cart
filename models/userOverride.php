<?php
	/**
	 * @package     ${NAMESPACE}
	 * @subpackage
	 *
	 * @copyright   A copyright
	 * @license     A "Slug" license name e.g. GPL2
	 */
	
	class VirtueMartModelUserOverride  extends VirtueMartModelUser {
		/**
		 * VirtueMartModelUserOverride constructor.
		 * @since 3.9
		 */
		function __construct()
		{
			parent::__construct();
			JLoader::register( 'VirtueMartModelUserfieldsOverride', JPATH_PLUGINS . '/system/plg_system_vm_cart/models/userfieldsOverride.php' );
		}
		
		/**
		 * @param      $layoutName
		 * @param      $type
		 * @param      $uid
		 * @param bool $cart
		 * @param bool $isVendor
		 *
		 * @return array|bool
		 *
		 * @since 3.9
		 */
		function getUserInfoInUserFields($layoutName, $type,$uid,$cart=true,$isVendor=false ){
			
			$userFieldsModel = VmModel::getModel('UserfieldsOverride');
			$prepareUserFields = $userFieldsModel->getUserFieldsFor( $layoutName, $type );
			
			if($type=='ST'){
				$preFix = 'shipto_';
			} else {
				$preFix = '';
			}
			/*
			 * JUser  or $this->_id is the logged user
			 */
			if(!empty($this->_data->JUser) and $this->_data->JUser->id==$this->_id){
				$JUser = $this->_data->JUser;
			} else {
				if(empty($this->_data)){
					$JUser = JUser::getInstance($this->_id);
				} else {
					$JUser = $this->_data->JUser = JUser::getInstance($this->_id);
				}
			}
			
			$data = null;
			$userFields = array();
			if(!empty($uid)){
				
				$dataT = $this->getTable('userinfos');
				$data = $dataT->load($uid);
				
				if($data->virtuemart_user_id!==0 and !$isVendor){
					
					$user = JFactory::getUser();
					if(!vmAccess::manager()){
						if($data->virtuemart_user_id!=$this->_id){
							vmError('Blocked attempt loading userinfo, you got logged');
							echo 'Hacking attempt loading userinfo, you got logged';
							return false;
						}
					}
				}
				
				if ($data->address_type != 'ST' ) {
					$BTuid = $uid;
					
					$data->name = $JUser->name;
					$data->email = $JUser->email;
					$data->username = $JUser->username;
					$data->address_type = 'BT';
					
				}
			} else {
				vmdebug('getUserInfoInUserFields case empty $uid');
				//New Address is filled here with the data of the cart (we are in the userview)
				if($cart){
					
					$cart = VirtueMartCart::getCart();
					$adType = $type.'address';
					
					if(empty($cart->{$adType})){
						$data = $cart->{$type};
						if(empty($data)) $data = array();
						
						if($JUser){
							if(empty($data['name'])){
								$data['name'] = $JUser->name;
							}
							if(empty($data['email'])){
								$data['email'] = $JUser->email;
							}
							if(empty($data['username'])){
								$data['username'] = $JUser->username;
							}
							if(empty($data['virtuemart_user_id'])){
								$data['virtuemart_user_id'] = $JUser->id;
							}
						}
						$data = (object)$data;
					}
					
				} else {
					
					if($JUser){
						if(empty($data['name'])){
							$data['name'] = $JUser->name;
						}
						if(empty($data['email'])){
							$data['email'] = $JUser->email;
						}
						if(empty($data['username'])){
							$data['username'] = $JUser->username;
						}
						if(empty($data['virtuemart_user_id'])){
							$data['virtuemart_user_id'] = $JUser->id;
						}
						$data = (object)$data;
					}
				}
			}
			
			if(empty($data) ) {
				vmdebug('getUserInfoInUserFields $data empty',$uid,$data);
				$cart = VirtueMartCart::getCart();
				$data = $cart->BT;
			}
			
			$userFields[$uid] = $userFieldsModel->getUserFieldsFilled(
				$prepareUserFields
				,$data
				,$preFix
			);
			
			return $userFields;
		}
		
	}