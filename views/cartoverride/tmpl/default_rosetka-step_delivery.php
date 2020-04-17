<?php
	/**
	 * @package     ${NAMESPACE}
	 * @subpackage
	 *
	 * @copyright   A copyright
	 * @license     A "Slug" license name e.g. GPL2
	 */
	
	defined( '_JEXEC' ) or die;
?>


<h3 class="check-step-title">
	<?= $this->loadTemplate( 'rosetka-step_delivery-title' ) ?>
</h3>
<div class="clearfix check-step-content hidden" name="step_content">
    <div class="check-order-msg hidden" id="attention">
        Внимание! Товары, находящиеся на&nbsp;разных складах, будут доставлены отдельными заказами
    </div>
    <div class="check-order-msg hidden" id="union_for_dc">
        Внимание! Товары будут доставлены отдельными заказами. Для того, чтобы заказ был доставлен быстрее, рекомендуем
        <a href="#" class="novisited xhr" id="union_for_dc_link">объединить заказы</a>
    </div>
	<?= $this->loadTemplate( 'rosetka-step_delivery-step_content' ) ?>
</div>

	

