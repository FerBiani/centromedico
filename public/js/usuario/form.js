
function atualizaValidacoes(target, validations) {
    $(target).each(function () {
        $(this).rules('add', validations);
    });
} 

function optionsJaSelecionados(target){
    let selecionados = []
    $(target).each(function() {
        if($(this).find('option:selected').val() != 'Selecione') {
            selecionados.push($(this).find('option:selected').val())
        }
    })
    return selecionados
}

function atualizarDisponibilidadeOptions(target) {

    let selecionados = optionsJaSelecionados(target)

    $(target).each(function(){
        $(this).find('option').each(function(){
            if(selecionados.includes($(this).val()) && !$(this).is(':selected')) {
                $(this).prop('disabled', true)
            } else {
                $(this).prop('disabled', false)
            }
        })
    })
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
            "usuario[nome]": {
                nome_sobrenome: true,
            },
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

    jQuery.validator.addMethod("cpf", function(value, element) {
        value = jQuery.trim(value);
     
         value = value.replace('.','');
         value = value.replace('.','');
         cpf = value.replace('-','');
         while(cpf.length < 11) cpf = "0"+ cpf;
         var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
         var a = [];
         var b = new Number;
         var c = 11;
         for (i=0; i<11; i++){
             a[i] = cpf.charAt(i);
             if (i < 9) b += (a[i] * --c);
         }
         if ((x = b % 11) < 2) { a[9] = 0 } else { a[9] = 11-x }
         b = 0;
         c = 11;
         for (y=0; y<10; y++) b += (a[y] * c--);
         if ((x = b % 11) < 2) { a[10] = 0; } else { a[10] = 11-x; }
     
         var retorno = true;
         if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10]) || cpf.match(expReg)) retorno = false;
     
         return this.optional(element) || retorno;
     
     }, "Informe um CPF válido.");

    jQuery.validator.addMethod("nome_sobrenome", function(value, element) {
        // allow any non-whitespace characters as the host part
        return value.split(' ').length >= 2
    }, 'Informe o nome e sobrenome.');

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
    if($('#niveis').find('option:selected').val() == '3' || $('#nivel_id_fixed').val() == '3') {
        //especializacoes
        $('select.especializacoes').removeAttr('disabled')
        $('#especializacoes').removeAttr('hidden')

        //tempo retorno
        $('.tempo_retorno').removeAttr('disabled').removeAttr('hidden')

        //crm
        $('#crm').removeAttr('hidden')
        $('input[name="crm[tipo_documentos_id]"]').val('4').removeAttr('disabled')
        $('input[name="crm[numero]"]').removeAttr('disabled')

    } else {
        //especializacoes
        $('select.especializacoes').attr('disabled', 'disabled')
        $('#especializacoes').attr('hidden', 'hidden')

        //tempo retorno
        $('.tempo_retorno').attr('disabled', 'disabled').attr('hidden', 'hidden').val('')

        //crm
        $('#crm').attr('hidden', 'hidden')
        $('input[name="crm[tipo_documentos_id]"]').val('').attr('disabled', 'disabled')
        $('input[name="crm[numero]"]').val('').attr('disabled', 'disabled')
    }

    $.each($('.select-documentos'), function() {
        if($(this).find('option:selected').val() == '2') {
            $(this).parents().closest('.doc').find('input.documento').eq(0).mask('999.999.999-99').rules("add", "cpf");
        } else {
            $(this).parents().closest('.doc').find('input.documento').eq(0).unmask().rules("remove", "cpf");
        }
    })

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

    $(document).on("change", ".esp", function() {

        atualizarDisponibilidadeOptions('.esp')
 
     ""})
    
    $(document).on('click', '.add-esp', function() {
        if($('.esp').length < 10) {

            let selecionados = optionsJaSelecionados('.esp')

            clonar('.esp', '#especializacoes', true)
            $('.esp').last().find('.add-esp')
                .removeClass('add-esp')
                .addClass('del-esp')
                .find('i')
                .removeClass('fa fa-plus')
                .addClass('fa fa-trash')

            $('.esp').last().find('option').each(function(){
                if(selecionados.includes($(this).val())) {
                    $(this).prop('disabled', true)
                }
            })
            
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

            atualizarDisponibilidadeOptions('.esp')
        }
    })

    $(document).on("change", ".doc", function() {

       atualizarDisponibilidadeOptions('.doc')

    })
    
    $(document).on('click', '.add-doc', function() {
        if($('.doc').length < 10) {

            let selecionados = optionsJaSelecionados('.doc')

            clonar('.doc', '#documentos', true)
            $('.doc').last().find('.add-doc')
                .removeClass('add-doc')
                .addClass('del-doc')
                .find('i')
                .removeClass('fa fa-plus')
                .addClass('fa fa-trash')

            $('.doc').last().find('option').each(function(){
                if(selecionados.includes($(this).val())) {
                    $(this).prop('disabled', true)
                }
            })

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

            atualizarDisponibilidadeOptions('.doc')
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

//Evento executado quando o nível é alterado
$(document).on('change', '#niveis', function() {
    if($(this).find('option:selected').val() == '3') {
        //especializacoes
        $('select.especializacoes').removeAttr('disabled');
        $('#especializacoes').removeAttr('hidden')

        //tempo retorno
        $('.tempo_retorno').removeAttr('disabled').removeAttr('hidden');

        //crm
        $('#crm').removeAttr('hidden')
        $('input[name="crm[tipo_documentos_id]"]').val('4').removeAttr('disabled')
        $('input[name="crm[numero]"]').removeAttr('disabled')

    } else {
        //especializacoes
        $('select.especializacoes').attr('disabled', 'disabled')
        $('#especializacoes').attr('hidden', 'hidden')

        //tempo retorno
        $('.tempo_retorno').attr('disabled', 'disabled').attr('hidden', 'hidden').val('')

        //crm
        $('#crm').attr('hidden', 'hidden')
        $('input[name="crm[tipo_documentos_id]"]').val('').attr('disabled', 'disabled')
        $('input[name="crm[numero]"]').val('').attr('disabled', 'disabled')
    }
})

//Evento executado quando um tipo de documento é alterado
$(document).on('change', '.select-documentos', function() {
    if($(this).find('option:selected').val() == '2') {
        $(this).parents().closest('.doc').find('input.documento').eq(0).mask('999.999.999-99').rules("add", "cpf")
    } else {
        $(this).parents().closest('.doc').find('input.documento').eq(0).unmask().rules("remove", "cpf")
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
