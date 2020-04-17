<?php
	/**
	 * @package     ${NAMESPACE}
	 * @subpackage
	 *
	 * @copyright   A copyright
	 * @license     A "Slug" license name e.g. GPL2
	 */
	
	defined('_JEXEC') or die;
	?>

 
	<h3 class="check-step-title">
		<?= $this->loadTemplate( 'rosetka-step_contacts-title' ) ?>
	</h3>

	
	<div class="clearfix check-step-content" name="step_content">
		<?= $this->loadTemplate( 'rosetka-tab_menu' ) ?>
		<div class="check-step-part" name="new_user_tab">
			<div name="valid_block">
				<?= $this->loadTemplate( 'rosetka-user-field' ) ?>
			</div>
			<div class="clearfix f-i grid-box-top" name="next_field">
				<div class="check-f-i-field">
                    <span class="btn-link btn-link-green check-step-btn-link opaque disabled">
                        <button class="btn-link-i" name="next_step" tabindex="6">Далее</button>
                    </span>
				</div>
			</div>
		</div>
	</div>
	<?php // Блок - войти  форма входа на сайт + Войти как пользователь СоцСети ?>
	<?= $this->loadTemplate( 'rosetka-user-member_user_tab' ) ?>

