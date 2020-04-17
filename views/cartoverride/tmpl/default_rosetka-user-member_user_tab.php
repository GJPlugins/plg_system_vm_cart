<?php
	/**
	 * Блок - войти  форма входа на сайт + Войти как пользователь СоцСети
	 * @package     ${NAMESPACE}
	 * @subpackage
	 *
	 * @copyright   A copyright
	 * @license     A "Slug" license name e.g. GPL2
	 */
	defined('_JEXEC') or die;
	?>

<div class="clearfix check-step-content hidden" name="member_user_tab">
	<div class="check-auth" id="auth" data-check-auth="или">
		<div name="app-message"></div>
		<div class="clearfix" name="auth_email_block">
			<div class="check-f-i-title-vert check-f-i-title-vert-indent">Эл.&nbsp;почта или телефон</div>
			<div class="check-f-i-field-vert">
				<input class="input-text check-input-text" name="user[login]"
				       _pattern="^([^\​\n]+)@([^\​\n]+)\.([^\​\n]+)$|^\s*((\+?\s*(\(\s*)?3)?[\s\-]*(\(\s*)?8[\s\-]*)?(\(\s*)?0[\s\-\(]*[1-9][\s\-]*\d(\s*\))?([\s\-]*\d){7}\s*$"
				       _required="required" type="text" value="" tabindex="1" data-title="Эл.&nbsp;почта">
			</div>
			<div class="check-msg-tooltip check-tooltip check-tooltip-blacklist sprite-side hidden" name="auth_email_msg_block"></div>
			<div class="check-msg-tooltip check-tooltip sprite-side hidden" name="return_block" id="return_block">
				<div name="login_hint"></div>
				<div class="f-i">
					<input class="input-text check-auth-input-text check-input-text" type="password" _required="required" name="user[temp_pass]" data-title="Временный пароль" tabindex="2">
					<div class="hidden" name="auth_msg_block">
						<div class="check-tooltip-msg" name="auth_msg">
							Введен неверный пароль!
						</div>
						<div class="check-tooltip-note">
							Проверьте раскладку клавиатуры и&nbsp;Caps Lock
						</div>
					</div>
					<div name="recaptcha_placeholder"> </div>
					<script>
                        document.addEvent('loadCaptchaScript', function () {ReCaptcha.init($('return_block'));});
					</script>
					<div class="check-tooltip-remember-pass-submit">
<span class="btn-link btn-link-gray">
<input class="btn-link-i" type="submit" name="temp_submit" value="Войти" data-title="Войти" tabindex="4">
</span>
					</div>
					<div class="check-remember-pass">
						<a href="https://my.rozetka.com.ua/checkout/#signin" class="xhr novisited active" name="pass_sent_remembered_button" tabindex="3">Я вспомнил свой пароль</a>
					</div>
				</div>
			</div>
		</div>
		<div name="authorization" class="" id="authorization">
			<div class="clearfix f-i">
				<div class="check-f-i-title-vert">Пароль</div>
				<div class="check-f-i-field-vert">
					<input type="password" class="input-text check-input-text" _required="required" _pattern="^.{6,}$" name="user[password]" tabindex="2" data-title="Пароль">
				</div>
				<div class="check-msg-tooltip check-tooltip sprite-side hidden" name="auth_msg_block">
					<div class="check-tooltip-msg" name="auth_msg">
						Введен неверный пароль!
					</div>
					<div class="check-tooltip-note">
						Проверьте раскладку клавиатуры и&nbsp;Caps Lock
					</div>
					<div class="check-tooltip-text">
						<a href="#" class="xhr novisited" name="send_temp_pass" tabindex="3">Пришлите мне временный пароль</a><br>
						на&nbsp;указанный адрес электронной почты
					</div>
				</div>
			</div>
			<div name="recaptcha_placeholder">
			
			</div>
			<script>
                document.addEvent('loadCaptchaScript', function () {ReCaptcha.init($('authorization'));});
			</script>
			<div class="clearfix f-i clean-bottom">
<span class="btn-link btn-link-green check-step-btn-link">
<button class="btn-link-i" id="signin" name="auth_submit" tabindex="3">Войти</button>
</span>
				<a href="https://my.rozetka.com.ua/remind-password/" class="xhr novisited check-forgot-pass-link" name="forgot_button" tabindex="4">Я забыл пароль</a>
			</div>
		</div>
		<div name="remind_password" class="hidden">
			<div name="recaptcha_placeholder">
			
			</div>
			<script>
                document.addEvent('loadCaptchaScript', function () {ReCaptchaRemindPassword.init($E('[name=remind_password]'));});
			</script>
			<div class="clearix f-i">
				<div class="check-remember-pass-submit">
<span class="btn-link btn-link-gray check-remember-pass-submit-btn">
<input class="btn-link-i" type="submit" name="send_temp_pass_button" value="Получить временный пароль" data-title="Получить временный пароль" tabindex="2">
</span>
				</div>
				<div name="remind_tries_msg" class="check-remember-pass-hint lightgray"></div>
				<div class="check-remember-pass">
					<a href="https://my.rozetka.com.ua/checkout/#signin" class="xhr novisited active" name="remembered_button" tabindex="3">Я вспомнил свой пароль</a>
				</div>
			</div>
		</div>
	</div>
	<aside class="check-auth-social">
		<div class="social-bind-profile">
			<h5 class="check-auth-social-title">Войти как пользователь</h5>
			<div class="check-social-auth-link-wrap" id="social_success">
				<div name="social_button_auth_checkout" type="facebook" class="inline check-social-auth-btn" data-location="checkout"><a target="_blank" href="http://www.facebook.com/v4.0/dialog/oauth/?client_id=205429962821175&amp;redirect_uri=https%3A%2F%2Fmy.rozetka.com.ua%2Fsignin%2Foauth%2Ffacebook%2F&amp;display=popup&amp;scope=public_profile%2Cemail%2Cuser_likes&amp;state=9b910c27a6dce28493718855de8b2722" class="profile-social-bind-link" id="checkout_auth_fb" onclick="document.fireEvent('clickSocial', {extend_event: [{name: 'eventContent', value: 'Facebook'},{name: 'eventLocation', value: 'checkout'}]})"> <img class="sprite check-social-auth-icon-fb" src="https://i.rozetka.ua/design/_.gif" width="28" height="28" alt="Facebook"> </a></div>
				<div name="social_button_auth_checkout" type="google" class="inline check-social-auth-btn" data-location="checkout"><a target="_blank" href="https://accounts.google.com/o/oauth2/auth?client_id=5458514456-8gm2oc3quosun7cj5p56nmiurcv7npjn.apps.googleusercontent.com&amp;redirect_uri=https%3A%2F%2Fmy.rozetka.com.ua%2Fsignin%2Foauth%2Fgoogle%2F&amp;display=popup&amp;response_type=code&amp;scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.profile&amp;state=9b910c27a6dce28493718855de8b2722" class="profile-social-bind-link" id="checkout_auth_g" onclick="document.fireEvent('clickSocial', {extend_event: [{name: 'eventContent', value: 'Google+'},{name: 'eventLocation', value: 'checkout'}]})"> <img class="sprite check-social-auth-icon-g" src="https://i.rozetka.ua/design/_.gif" width="28" height="28" alt="Google"> </a></div>
				<div id="social_msg"></div>
			</div>
			<p class="f-i-sign">
				Мы&nbsp;не&nbsp;передаем социальным сетям<br>никаких данных и&nbsp;не&nbsp;постим ничего<br>у&nbsp;вас на&nbsp;стенах!
			</p>
			<div id="msg" class="social_error"></div>
		</div>
		<script>
            OAuth2.setOptions({
                tpl:{
                    facebook: '{if !User.isAuthInSocial(\"facebook\")} <a href=\"http:\/\/www.facebook.com\/v4.0\/dialog\/oauth\/?client_id=205429962821175&redirect_uri=https%3A%2F%2Fmy.rozetka.com.ua%2Fsignin%2Foauth%2Ffacebook%2F&display=popup&scope=public_profile%2Cemail%2Cuser_likes\" class=\"check-confirm-auth-social\" id=\"checkout_auth_fb\"> <img src=\"https:\/\/i.rozetka.ua\/design\/_.gif\" width=\"50\" height=\"50\" alt=\"Facebook\" class=\"success-fb sprite\"> <\/a> {\/if}',
                    google: '{if !User.isAuthInSocial(\"google\")} <a href=\"https:\/\/accounts.google.com\/o\/oauth2\/auth?client_id=5458514456-8gm2oc3quosun7cj5p56nmiurcv7npjn.apps.googleusercontent.com&redirect_uri=https%3A%2F%2Fmy.rozetka.com.ua%2Fsignin%2Foauth%2Fgoogle%2F&display=popup&response_type=code&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.profile\" class=\"check-confirm-auth-social\" id=\"checkout_auth_g\"> <img src=\"https:\/\/i.rozetka.ua\/design\/_.gif\" width=\"53\" height=\"53\" alt=\"Google\" class=\"success-g sprite\"> <\/a> {\/if}'
                }
            });
            OAuth2.addEvent('login_failed', function(e) {
                $('social_msg').setHTML(e.value);
            });
            OAuth2.addEvent('login_success', function(e) {
                window.location.reload();
            });
            OAuth2.update();
            User.setNeedOAuthUpdate(false);
		</script>
	</aside>
</div>
