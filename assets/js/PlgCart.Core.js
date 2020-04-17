var PlgCartCore = function () {
    var $ = jQuery ;
    /**
     * @type {FPhone}
     */
    var self = this ;
    /**
     * Кнопка "ДАЛЕЕ" SPAN
     * @type {JQuery<HTMLElement> | jQuery | HTMLElement}
     */
    var $check_step_btn_link = $('.check-step-btn-link');


    this.initForm = function () {
        // Повесить оработчичи на потерю фокуса элементами Input
        self.addEvtBlur();
        // Оработка кнопки ДАЛЕЕ
        self.checkStepBtn();
    }
    /**
     * Оработка кнопки далее
     */
    this.checkStepBtn = function () {
        var $step_contacts = $('#step_contacts');
        var $step_delivery = $('#step_delivery');
        var $check_step_edit_link = $('.check-step-edit-link');
        var $step_contacts_content = $step_contacts.find('[name="step_content"]');
        var $step_delivery_content = $step_delivery.find('[name="step_content"]');

        $($check_step_btn_link).on('click', function( event ){
            event.preventDefault();
            if ($(this).hasClass('disabled')) return ;

            $step_contacts.addClass('completed');
            $step_contacts_content.addClass('hidden');
            $step_delivery.removeClass('disabled');
            $check_step_edit_link.removeClass('hidden');
            $step_delivery_content.removeClass('hidden');
            contactUpdate();
        });
        $check_step_edit_link.on('click' , function (event) {
            event.preventDefault();
            $step_contacts.removeClass('completed');
            $step_contacts_content.removeClass('hidden');

            $step_delivery.addClass('disabled');
            $check_step_edit_link.addClass('hidden');
            $step_delivery_content.addClass('hidden');
        })
        function contactUpdate() {
            var userfields_in_title = Joomla.getOptions('userfields_in_title');
            var $userName = $('[name="check-step-user-name"]')
            var $userPhone = $('[name="check-step-user-phone"]');
            var $delivery_title = $('[name="delivery_title"] .check-delivery-title-city-text');


            var val1 = $('[name="'+userfields_in_title[0]+'"]').val()
            var val2 = $('[name="'+userfields_in_title[1]+'"]').val();
            var city = $('[name="city"]').val();

            $userName.html(val1) ;
            $userPhone.html(val2) ;
            $delivery_title.html(city) ;
        }
    }




    /**
     * Повесить оработчичи на потерю фокуса элементами required
     */
    this.addEvtBlur = function () {
        // Найти активынй ТАБ
        var $tab = this.getActiveTabs() ;
        var $field = $tab.find('input[_required="required"]');

        $field.each(function (i , elem) {
            elem.addEventListener("blur",  self.contactsValid ,  true);
        })
    }


    /**
     * Найти активынй ТАБ
     * @returns {*|number|bigint|T|T}
     */
    this.getActiveTabs = function () {
        var $step_contacts = $('#step_contacts') ;
        var $activeMenuTabName = $step_contacts.find('[name="tab_menu"] >li.active').attr('name');
        var $tab =  $step_contacts.find('[name="'+$activeMenuTabName+'_tab"]') ;
        return $tab ;
    }

    /**
     * Валидатор контактов покупателя
     */
    this.contactsValid = function (  event ) {
        var valid = true ;

        // список с выбором телефонов
        var $phone_select_option_selected = $('#phone_select').find('option:selected')
        var $reciever_phone = $('#reciever_phone')
        if ( $phone_select_option_selected.val() !== 'new'){
            $reciever_phone.removeAttr('_required');
        }else{
            $reciever_phone.attr('_required' , 'required' ) ;
        }


        // Найти активынй ТАБ
        var $tab = self.getActiveTabs() ;
        var $field = $tab.find('input[_required="required"]');

        $field.each(function (i,a) {
            var $element = $(a)
            var min_phone_number = $element.data('min_phone_number') ;
            var val = $element.val()
            if (  val === '' ) {
                valid = false ;
            }
            if ( typeof min_phone_number === 'undefined') return ;
            var D_val = val.replace(/[^\d]/g, '');
            if (D_val.length < min_phone_number ) valid = false ;
        });
        if (valid){
            $('.check-step-btn-link > button').parent().removeClass('disabled');
        }else{
            $('.check-step-btn-link > button').parent().addClass('disabled');
        }




    }


};
(function () {
    var Core = new PlgCartCore();
    Core.contactsValid();
    Core.initForm();
})()
