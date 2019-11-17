
function atualizaValidacoes(target, validations) {
    $(target).each(function () {
        $(this).rules('add', validations);
    });
} 

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
        },

        rules: {
            "usuario[nome]": "required",

            "usuario[email]": {
                required:true,
                email:true, 
            },
        
            "usuario[password]": {
                required: true,
                minlength: 6,
                maxlength: 10
            },

            "usuario[password_confirmation]":{
                required: true,
                minlength: 6,
                maxlength: 10,
                equalTo: "#password"
            },

            "usuario[nivel_id]": "required",
            "endereco[cep]": "required",
            "endereco[estado]": "required",
            "endereco[cidade]": "required",
            "endereco[bairro]": { required: true, maxlength: 100 },
            "endereco[logradouro]": { required: true, maxlength:100 },
            "endereco[numero]":{ required: true, digits: true },
            "endereco[complemento]": { maxlength:255 },
        },

        messages: {

            "usuario[nome]":{
                required: 'Este campo é obrigatório',
            },

            "usuario[email]":{
                email:'Digite um email válido', 
                required: 'O campo e-mail é obrigatório',
            },

            "usuario[password]":{
                required:  'Este campo é obrigatório',
                minlength: 'Sua senha deve ter pelo menos 6 caracteres.',
                maxlength: 'Sua senha não deve ter mais de 10 caracteres'

            },

            "usuario[password_confirmation]":{
                required: 'Este campo é obrigatório',
                minlength: 'Sua senha deve ter pelo menos 6 caracteres.',
                maxlength: 'Sua senha não deve ter mais de 10 caracteres',
                equalTo: 'As duas senhas devem ser iguais'
            },

            "usuario[nivel_id]": { 
                required: 'Este campo é obrigatório'
            },
            
            "endereco[cep]": {
                required: 'Este campo é obrigatório'
            },
            
            "endereco[estado]": {
                required: 'Este campo é obrigatório'
            },
            
            "endereco[cidade]": {
                required: 'Este campo é obrigatório'
            },
            
            "endereco[bairro]": {
                required: 'Este campo é obrigatório',
                maxlength: 'Este campo não pode ter mais de 100 caracteres'
            },

            "endereco[logradouro]":{
                required: 'Este campo é obrigatório',
                maxlength: 'Este campo não pode ter mais de 100 caracteres'
            },

            "endereco[numero]":{
                required: 'O campo número é obrigatório',
                digits:   'Este campo deve ter somente valores numericos',
            },
        },
    });

    const telefoneRules = {
        required: true,
        minlength:14,
        maxlength:15,
        messages: {
            required: 'Este campo é obrigatório',
            minlength: 'Este campo deve ter pelo menos 10 caracteres',
            maxlength: 'Este campo não pode passar de 11 caracteres'
        }
    }

    atualizaValidacoes('.telefone', telefoneRules)
    atualizaValidacoes('.documento', {
        required: true,
        messages: {
            required: 'Este campo é obrigatório!'
        }
    })

    //Mostra os campos exclusivos do médico no carregamento da página
    if($('#niveis').find('option:selected').val() == '3') {
        //especializacoes
        $('select.especializacoes').removeAttr('disabled')
        $('#especializacoes').removeAttr('hidden')

        //tempo retorno
        $('#tempo_retorno').removeAttr('disabled').removeAttr('hidden')

        //crm
        $('#crm').removeAttr('hidden')
        $('input[name="crm[tipo_documentos_id]"]').val('4').removeAttr('disabled')
        $('input[name="crm[numero]"]').removeAttr('disabled')

    } else {
        //especializacoes
        $('select.especializacoes').attr('disabled', 'disabled')
        $('#especializacoes').attr('hidden', 'hidden')

        //tempo retorno
        $('#tempo_retorno').attr('disabled', 'disabled').attr('hidden', 'hidden').val('')

        //crm
        $('#crm').attr('hidden', 'hidden')
        $('input[name="crm[tipo_documentos_id]"]').val('').attr('disabled', 'disabled')
        $('input[name="crm[numero]"]').val('').attr('disabled', 'disabled')
    }

    $(document).on('click', '.add-tel', function() {
        if($('.tel').length < 4) {
            clonar('.tel', '#telefones', true)
            mascararTel($('.tel').last().find('input'))
            $('.tel').last().find('.add-tel')
                .removeClass('add-tel')
                .addClass('del-tel')
                .find('i')
                .removeClass('fa fa-plus')
                .addClass('fa fa-trash')

            atualizaValidacoes('.telefone', telefoneRules)

        } else {
            Swal.fire(
                'Atenção!',
                'Podem ser adicionados no máximo '+$(".tel").length+' telefones',
                'warning'
            )
        }
    })

    $(document).on("click", ".del-tel", function() {
        if($(".tel").length > 1) {
            remover(".tel", $(this))
        }
    })
    
    $(document).on('click', '.add-esp', function() {
        if($('.esp').length < 10) {
            clonar('.esp', '#especializacoes', true)
            $('.esp').last().find('.add-esp')
                .removeClass('add-esp')
                .addClass('del-esp')
                .find('i')
                .removeClass('fa fa-plus')
                .addClass('fa fa-trash')
        } else {
            Swal.fire(
                'Atenção!',
                'Podem ser adicionadas no máximo '+$(".esp").length+' especializações',
                'warning'
            )
        }
    })
    
    $(document).on("click", ".del-esp", function() {
        if($(".esp").length > 1) {
            remover(".esp", $(this))
        }
    })
    
    $(document).on('click', '.add-doc', function() {
        if($('.doc').length < 10) {
            clonar('.doc', '#documentos', true)
            $('.doc').last().find('.add-doc')
                .removeClass('add-doc')
                .addClass('del-doc')
                .find('i')
                .removeClass('fa fa-plus')
                .addClass('fa fa-trash')

            atualizaValidacoes('.documento', {
                required: true,
                messages: {
                    required: 'Este campo é obrigatório!'
                }
            })

        } else {
            alert()
            Swal.fire(
                'Atenção!',
                'Podem ser adicionados no máximo '+$(".doc").length+' documentos',
                'warning'
            )
        }
    })
    
    $(document).on("click", ".del-doc", function() {
        if($(".doc").length > 1) {
            remover(".doc", $(this))
        }
    })

})

$('#cep').blur(function(){
    var cep = $(this).val().replace(/\D/g, '');
    if(cep != ""){
        var validacep = /^[0-9]{8}$/;   
        if(validacep.test(cep)) {
            $('#logradouro').val('...');

            $.ajax({
                url: "https://viacep.com.br/ws/"+ cep +"/json/",
                type: 'GET',
                dataType: "json",
                success: function(dados){
                    //Atualiza os campos com os valores da consulta.

                    $(".estados option").each(function() {
                        if($(this).text() == dados.uf){
                            $(this).attr('selected', 'selected')
                        }
                    })

                    $("#cidade").val(dados.localidade)
                    $("#logradouro").val(dados.logradouro)
                    $("#bairro").val(dados.bairro)
                    $("#numero").focus()
                }
            })
        }
    }
});

$(document).on('change', '#niveis', function() {
    if($(this).find('option:selected').val() == '3') {
        //especializacoes
        $('select.especializacoes').removeAttr('disabled');
        $('#especializacoes').removeAttr('hidden')

        //tempo retorno
        $('#tempo_retorno').removeAttr('disabled').removeAttr('hidden');

        //crm
        $('#crm').removeAttr('hidden')
        $('input[name="crm[tipo_documentos_id]"]').val('4').removeAttr('disabled')
        $('input[name="crm[numero]"]').removeAttr('disabled')

    } else {
        //especializacoes
        $('select.especializacoes').attr('disabled', 'disabled')
        $('#especializacoes').attr('hidden', 'hidden')

        //tempo retorno
        $('#tempo_retorno').attr('disabled', 'disabled').attr('hidden', 'hidden').val('')

        //crm
        $('#crm').attr('hidden', 'hidden')
        $('input[name="crm[tipo_documentos_id]"]').val('').attr('disabled', 'disabled')
        $('input[name="crm[numero]"]').val('').attr('disabled', 'disabled')
    }
})

//ENDEREÇO
function selecionarEstado(uf) {
    $(".estados option").removeAttr('selected')
    $(".estados option").each(function() {
        if($(this).data("uf") == uf){
            $(this).attr('selected', 'selected')
        }
    })
}

//MÁSCARAS
$('.cep').mask('00000-000')
$('.telefone').each(function(i,tel){
    mascararTel(tel)
})
