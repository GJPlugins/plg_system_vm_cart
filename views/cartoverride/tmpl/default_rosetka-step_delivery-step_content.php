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


<div id="orders" style>
    <div class="check-order-wrap">
        <div class="check-order" data-check-order="Заказ недоступен">
            <!-- Список товаров в корзине	        -->
            <div name="purchases">
				<?php
					$this->rendererLayout->setLayout( 'purchases' );
					# Перебираем товары в корзине
					foreach ($this->cart->products as $product)
					{
						echo $this->rendererLayout->render( [ 'product' => $product, 'currencyDisplay' => $this->currencyDisplay ] );
						
					}#END FOREACH
				?>
            </div>
            <!-- Выюор способов доставки           -->
            <div class="check-order-i">
                <div class="clearfix f-i">
                    <div name="delivery_same_day"></div>
                    <div class="check-delivery-title-wrap clearfix">
                        <div name="discount_label" class="check-delivery-premium-label hidden"></div>
                        <div class="check-delivery-title" name="delivery_title">
                            Доставка в
                            <span class="check-delivery-title-city">
                                <span class="check-delivery-title-city-text" data-name="city_title">Мариуполь - Донецкая обл.</span>
                                <a href="#" class="check-delivery-title-city-info info" name="delivery_info"
                                   order_index="1">
                                    <img class="sprite info-icon" src="https://i.rozetka.ua/design/_.gif" width="14"
                                         height="15" alt="Подробнее"></a>
                            </span>
                        </div>
                        <a href="#" class="check-delivery-city-choose xhr" data-name="city_chooser">Изменить город</a>
                    </div>
                    <div class="check-f-i-field-indent">
                        <div class="check-order-subi">
                            
                            <span name="pickups" style="display: none;" class="active">
                                <span name="pickups_block" style="display: none;" class=""></span>
                            </span>
                            
                            <span name="couriers" style="display: none;" class="">
                                <span name="couriers_block" style="display: none;" class="hidden"></span>
                            </span>
                            
                            <div class="check-f-i-field check-method-subl-with-time" name="delivery_block">
                                <div class="check-method-subl-note check-method-subl-note-indent hidden"
                                     data-name="attention_about_delivery">
                                    <div class="check-order-remark sprite-side">
                                        Внимание! Убедитесь, что выбран подходящий способ доставки
                                    </div>
                                </div>
                                
                                <ul class="check-method-subl">
                                    <?php
	                                    foreach ($this->shipments_shipment_rates as $shipment_shipment_rates) {
		                                    if (is_array($shipment_shipment_rates)) {
			                                    foreach ($shipment_shipment_rates as $shipment_shipment_rate) {
				                                    echo '<div class="vm-shipment-plugin-single">'.$shipment_shipment_rate.'</div>';
			                                    }
		                                    }
	                                    }
                                    ?>
                                    
                                    
                                </ul>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





