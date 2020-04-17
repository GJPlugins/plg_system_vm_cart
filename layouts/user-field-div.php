<?php
	/**
	 * @package     ${NAMESPACE}
	 * @subpackage
	 *
	 * @copyright   A copyright
	 * @license     A "Slug" license name e.g. GPL2
	 */
	
	extract( $displayData );
	
	$descr = empty( $field[ 'description' ] ) ? $field[ 'title' ] : $field[ 'description' ];

?>

<div class="clearfix check-f-i-<?=$field['name']?>">
	
    <div class="check-f-i-title check-f-i-title-indent" title="<?php echo strip_tags( $descr ) ?>">
	    <?= $field[ 'title' ] . ( $field[ 'required' ] ? ' <span class="asterisk">*</span>' : '' ) ?>
    </div>
    <div class="check-f-i-field">
	    <?php echo $field[ 'formcode' ] ?>
    </div>
</div>