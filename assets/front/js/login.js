var Login = function() {

    var register = function (){
        $('#registerform').validate({
                rules: {
                    username: {required: true},
                    email: {required: true,email: true},
                    password: {required: true},
                },
            highlight: function (element) { // hightlight error inputs
                $(element).closest('.form-control').addClass('has-error');

            },
            unhighlight: function (element) { // revert the change done by hightlight
                $(element).closest('.form-control').removeClass('has-error');
            },
            success: function (label) {
                label.closest('.form-control').removeClass('has-error'); 
            },
            errorPlacement: function (error, element) {
                return false;
            },
                submitHandler: function(form) {
                    ajaxcall($(form).attr('action'), $(form).serialize(), function (output) {
                        handleAjaxResponse(output);
                    });
                }
        });
    }
    return{
        init: function() {
            register();
        },
    };
}();