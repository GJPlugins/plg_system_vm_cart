<?php
	defined('_JEXEC') or die;
	
//	$layoutName = $this->getLayout();
//	echo'<pre>';print_r( $layoutName );echo'</pre>'.__FILE__.' '.__LINE__;
//	die(__FILE__ .' '. __LINE__ );
	
	$style_cart = $this->plg_system_vm_cart_params['style_template'] ;
	?>
	<div id="<?=$style_cart?>__section">
<?php
	
	echo  $this->loadTemplate( $style_cart ) ;
?>
	</div>
<?php
	
	
	//	echo'<pre>';print_r( $this->userFields );echo'</pre>'.__FILE__.' '.__LINE__;
//	die(__FILE__ .' '. __LINE__ );
 
	
	