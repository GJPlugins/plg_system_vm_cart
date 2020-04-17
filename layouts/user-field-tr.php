<?php
	/**
	 * @package     ${NAMESPACE}
	 * @subpackage
	 *
	 * @copyright   A copyright
	 * @license     A "Slug" license name e.g. GPL2
	 */
	
	extract( $displayData );
	
	$descr = empty($field['description'])? $field['title']:$field['description'];

?>
	<tr title="<?php echo strip_tags($descr) ?>">
		<td class="key"  >
			<label class="<?php echo $field['name'] ?>" for="<?php echo $field['name'] ?>_field">
				<?php echo $field['title'] . ($field['required'] ? ' <span class="asterisk">*</span>' : '') ?>
			</label>
		</td>
		<td>
			<?php echo $field['formcode'] ?>
		</td>
	</tr>
