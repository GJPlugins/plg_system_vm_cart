<?php
	/**
	 * @package     ${NAMESPACE}
	 * @subpackage
	 *
	 * @copyright   A copyright
	 * @license     A "Slug" license name e.g. GPL2
	 */
	defined('_JEXEC') or die;
	
	$hidden = null ;
	if( $this->virtuemart_userinfo_id ) $hidden = 'hidden' ;  #END IF
	
	?>

<ul class="clearfix check-tabs-m <?=$hidden?>" name="tab_menu">
	<li class="check-tabs-m-i active" name="new_user">
		<a class="novisited check-tabs-m-link" href="#" onclick="setTimeout(function () {document.fireEvent('userTypeChange');}, 100);">Я новый покупатель</a>
	</li>
	<li class="check-tabs-m-i" name="member_user">
		<a class="novisited check-tabs-m-link" href="#signin" onclick="setTimeout(function () {document.fireEvent('userTypeChange');}, 100);">Я постоянный клиент</a>
	</li>
</ul>
