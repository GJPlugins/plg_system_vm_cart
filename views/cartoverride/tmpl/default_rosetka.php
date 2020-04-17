<?php
 
	use Joomla\CMS\HTML\HTMLHelper;
 
	defined('_JEXEC') or die;
	
	HTMLHelper::stylesheet(
	        JURI::base().'plugins/system/plg_system_vm_cart/assets/css/rosetka/header.css'  ,
            array('relative' => true, /*'version' => 'auto',*/ 'pathOnly' => false, 'debug' => false));
	HTMLHelper::stylesheet(
		JURI::base().'plugins/system/plg_system_vm_cart/assets/css/rosetka/style.css'  ,
		array('relative' => true, /*'version' => 'auto',*/ 'pathOnly' => false, 'debug' => false));
	HTMLHelper::stylesheet(
		JURI::base().'plugins/system/plg_system_vm_cart/assets/css/rosetka/checkout.css'  ,
		array('relative' => true, /*'version' => 'auto',*/ 'pathOnly' => false, 'debug' => false));
	 
	
	
	?>
 



<h2 class="check-title">Оформление заказа</h2>
<div class="check-tabs" id="tabs-block">
    <div class="clearfix check-tabs-content">
        <div class="float-lt">
            <div class="grid-box-rt">
                <form class="check-f" id="checkout-form" onsubmit="return false;"
                      action=""
                      method="post"
                      data-title="Оформление заказа">
                    <!--  Контактные данные покупателя     -->
                    <section class="check-step" id="step_contacts"  >
                        <?= $this->loadTemplate( 'rosetka-step_contacts' )  ; ?>
                    </section>
                    
                    <!--  Доставка и оплата                  -->
                    <section class="check-step disabled" id="step_delivery"  >
		                <?= $this->loadTemplate( 'rosetka-step_delivery' )  ; ?>
                    </section>
                    
                    
                    
                    
                </form>
            </div>
        </div>
        <div id="purchases_container" class="pos-fix float-lt"> </div>
    </div>
</div>




 
 
 
	
	