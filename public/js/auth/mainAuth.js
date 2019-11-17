$(document).ready(function() {

    ///// VALIDATE /////
    $("#form").validate({
        highlight:function(input){
            jQuery(input).addClass('is-invalid');
        },

        unhighlight:function(input){
            jQuery(input).removeClass('is-invalid');
            jQuery(input).addClass('is-valid');
        },

        errorPlacement:function(error, element)
        {
            jQuery(element).parents('.form-group').find('#error').append(error);
        }

    })

})
