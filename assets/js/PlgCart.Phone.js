/**
 * Класс работы с полями телефонов
 * @constructor
 */
var FPhone = function () {
    var $ = jQuery;
    /**
     * @type {FPhone}
     */
    var self = this ;

    this.INIT = function () {
        // Init Маска для телефона
        self.maskInit();
    }
    /**
     * Инит Маска для телефона
     */
    this.maskInit = function () {
        var MaskCart = Joomla.getOptions('MaskCart' , {} );
        if (typeof MaskCart.mask_elements === 'undefined') return ;
        $.each( MaskCart.mask_elements , function ( i , el ) {
            var setting = {
                element : '[name="'+el.name+'"]' ,
                mask : '+380 (00) 000-00-00' ,
                placeholder :   true ,
                country:'UA',
                onComplete :  self.onCompletePhone  ,
            };
            wgnz11.getPlugin('Inputmask' , setting );
        } )

    };
    /**
     * Событие - маска добавленного телефона заполнена
     * @param val
     * @param element
     */
    this.onCompletePhone = function ( val ,  element ) {
        var plgCartCore = new PlgCartCore();
        plgCartCore.contactsValid( val ,  element );
        // newPhoneText = val ;
    };
    /**
     * Проверка на дубликат телефона в select
     * @param val
     * @returns {boolean}
     * @private
     */
    this._isDublecat = function (val) {
        const D_val = val.replace(/[^\d;]/g, '');
        const optDub = $phone_select.find('[value="' + D_val + '"]');
        if (optDub[0]) return true ;
        return false ;
    };

};



(function () {
    var A = new FPhone();
    A.INIT();
})();