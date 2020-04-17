<?php
	/**
	 * @package     ${NAMESPACE}
	 * @subpackage
	 *
	 * @copyright   A copyright
	 * @license     A "Slug" license name e.g. GPL2
	 */
	defined( '_JEXEC' ) or die;
	
	extract( $displayData );
	
	$subtotal = $currencyDisplay->createPriceDiv ('subtotal', '', $product->prices, TRUE, FALSE)  ;
	
	$image = $product->images[0];
	$descr = '';
	$imgHtml =  $image->displayMediaThumb($imageArgs='',$lightbox=false ,false , $return = true, $withDescr = false, $absUrl = false, $width=80,$height=61 );
	
	// TODO - Добавить вывод продавцов
 
	?>
 
<div class="clearfix check-g-i">
	
	<figure class="check-g-i-img">
		<a href="<?= JRoute::_( $product->link ); ?>"
		   target="_blank"
		   onclick="document.fireEvent('goodsImageClick', { extend_event:[{ name:'goods_id',value:12016684 }] });">
			<?= $imgHtml ?>
		</a>
	</figure>
	
	
	<div class="check-g-i-title">
		<a class="novisited check-g-i-title-link"
		   href="<?= JRoute::_( $product->link ); ?>"
		   target="_blank"
		   onclick="document.fireEvent('goodsTitleClick', { extend_event:[{ name:'goods_id',value:12016684 }] });">
			<?= $product->product_name ?>
		</a>
		<div class="check-g-i-title-merchant" name="seller_block" seller_id="5" popup_layout="bottom">
			<div> Продавец этого товара <span class="check-g-i-merchant-name">ТОВ E-lektra</span></div>
			<div name="popup_parent" class="pos-fix"></div>
		</div>
	</div>
	
	
	<div class="check-g-i-amount">
		<?= $product->quantity?> шт.
	</div>
	<div class="check-g-i-sum">
		<div class="check-g-i-sum-uah"><?= $subtotal?></div>
	</div>
</div>
	
	
	
	
	