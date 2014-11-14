/*  Author: Grapheme Group
 *  http://grapheme.ru/
 */

$(function(){

});


function runFormValidation() {

    var contact_feedback = $("#contact-feedback-form").validate({
        rules:{
            fio: {required : true},
            email: {required : true, email : true},
            //phone: {required : true},
            content: {required : true}
        },
        messages : {
            fio : {required : 'Укажите Ваше полное имя'},
            email : {required : 'Укажите адрес электронной почты'},
            phone : {required : 'Укажите контактный номер телефона'},
            content : {required : 'Укажите текст вопроса'}
        },
        errorPlacement : function(error, element){error.insertAfter(element.parent());},
        submitHandler: function(form) {
            var options = {target: null,dataType:'json',type:'post'};
            options.beforeSubmit = function(formData,jqForm,options){
                $(form).find('.btn-form-submit').elementDisabled(true);
            },
                options.success = function(response,status,xhr,jqForm){
                    $(form).find('.btn-form-submit').elementDisabled(false);
                    if(response.status){
                        if(response.redirect !== false){
                            BASIC.RedirectTO(response.redirect);
                        }
                        $(form).replaceWith(response.responseText);
                    }else{
                        showMessage.constructor(response.responseText,response.responseErrorText);
                        showMessage.smallError();
                    }
                }
            $(form).ajaxSubmit(options);
        }
    });

    var index_order_call = $("#index-order-call-form").validate({
        rules:{
            fio: {required : true},
            phone: {required : true},
            datetime: {required : true}
        },
        messages : {
            fio : {required : 'Укажите Ваше полное имя'},
            phone : {required : 'Укажите контактный номер телефона'},
            datetime : {required : 'Укажите время для звонка'}
        },
        errorPlacement : function(error, element){error.insertAfter(element.parent());},
        submitHandler: function(form) {
            var options = {target: null,dataType:'json',type:'post'};
            options.beforeSubmit = function(formData,jqForm,options){
                $(form).find('.btn-form-submit').elementDisabled(true);
            },
                options.success = function(response,status,xhr,jqForm){
                    $(form).find('.btn-form-submit').elementDisabled(false);
                    if(response.status){
                        if(response.redirect !== false){
                            BASIC.RedirectTO(response.redirect);
                        }
                        $(form).replaceWith(response.responseText);
                    }else{
                        showMessage.constructor(response.responseText,response.responseErrorText);
                        showMessage.smallError();
                    }
                }
            $(form).ajaxSubmit(options);
        }
    });

    var order_testdrive_call = $("#order-testdrive-form").validate({
        rules:{
            fio: {required : true},
            phone: {required : true},
            //email: {required : true, email : true},
            product_id: {required : true}
        },
        messages : {
            fio : {required : 'Укажите Ваше полное имя'},
            phone : {required : 'Укажите контактный номер телефона'},
            email : {required : 'Укажите адрес электронной почты'},
            product_id : {required : 'Укажите модель'}
        },
        errorPlacement : function(error, element){error.insertAfter(element.parent());},
        submitHandler: function(form) {
            var options = {target: null,dataType:'json',type:'post'};
            options.beforeSubmit = function(formData,jqForm,options){
                $(form).find('.btn-form-submit').elementDisabled(true);
            },
                options.success = function(response,status,xhr,jqForm){
                    $(form).find('.btn-form-submit').elementDisabled(false);
                    if(response.status){
                        if(response.redirect !== false){
                            BASIC.RedirectTO(response.redirect);
                        }
                        $(form).replaceWith(response.responseText);
                    }else{
                        showMessage.constructor(response.responseText,response.responseErrorText);
                        showMessage.smallError();
                    }
                }
            $(form).ajaxSubmit(options);
        }
    });

    var order_testdrive_call0 = $("#order-testdrive-form0").validate({
        rules:{
            fio: {required : true},
            phone: {required : true},
            //email: {required : true, email : true},
            product_id: {required : true}
        },
        messages : {
            fio : {required : 'Укажите Ваше полное имя'},
            phone : {required : 'Укажите контактный номер телефона'},
            email : {required : 'Укажите адрес электронной почты'},
            product_id : {required : 'Укажите модель'}
        },
        errorPlacement : function(error, element){error.insertAfter(element.parent());},
        submitHandler: function(form) {
            var options = {target: null,dataType:'json',type:'post'};
            options.beforeSubmit = function(formData,jqForm,options){
                $(form).find('.btn-form-submit').elementDisabled(true);
            },
                options.success = function(response,status,xhr,jqForm){
                    $(form).find('.btn-form-submit').elementDisabled(false);
                    if(response.status){
                        if(response.redirect !== false){
                            BASIC.RedirectTO(response.redirect);
                        }
                        $(form).replaceWith(response.responseText);
                    }else{
                        showMessage.constructor(response.responseText,response.responseErrorText);
                        showMessage.smallError();
                    }
                }
            $(form).ajaxSubmit(options);
        }
    });

    var order_service = $("#order-service-form").validate({
        rules:{
            fio: {required : true},
            phone: {required : true},
            //email: {required : true, email : true},
            product: {required : true}
        },
        messages : {
            fio : {required : 'Укажите Ваше полное имя'},
            phone : {required : 'Укажите контактный номер телефона'},
            email : {required : 'Укажите адрес электронной почты'},
            product : {required : 'Укажите модель'}
        },
        errorPlacement : function(error, element){error.insertAfter(element.parent());},
        submitHandler: function(form) {
            var options = {target: null,dataType:'json',type:'post'};
            options.beforeSubmit = function(formData,jqForm,options){
                $(form).find('.btn-form-submit').elementDisabled(true);
            },
                options.success = function(response,status,xhr,jqForm){
                    $(form).find('.btn-form-submit').elementDisabled(false);
                    if(response.status){
                        if(response.redirect !== false){
                            BASIC.RedirectTO(response.redirect);
                        }
                        $(form).replaceWith(response.responseText);
                    }else{
                        showMessage.constructor(response.responseText,response.responseErrorText);
                        showMessage.smallError();
                    }
                }
            $(form).ajaxSubmit(options);
        }
    });

    var order_reserve = $("#order-reserve-form").validate({
        rules:{
            fio: {required : true},
            phone: {required : true},
            //email: {required : true, email : true},
        },
        messages : {
            fio : {required : 'Укажите Ваше полное имя'},
            phone : {required : 'Укажите контактный номер телефона'},
            email : {required : 'Укажите адрес электронной почты'},
        },
        errorPlacement : function(error, element){error.insertAfter(element.parent());},
        submitHandler: function(form) {
            var options = {target: null,dataType:'json',type:'post'};
            options.beforeSubmit = function(formData,jqForm,options){
                $(form).find('.btn-form-submit').elementDisabled(true);
            },
                options.success = function(response,status,xhr,jqForm){
                    $(form).find('.btn-form-submit').elementDisabled(false);
                    if(response.status){
                        if(response.redirect !== false){
                            BASIC.RedirectTO(response.redirect);
                        }
                        $(form).replaceWith(response.responseText);
                    }else{
                        showMessage.constructor(response.responseText,response.responseErrorText);
                        showMessage.smallError();
                    }
                }
            $(form).ajaxSubmit(options);
        }
    });
}