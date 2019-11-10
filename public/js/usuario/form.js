
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

    // if($('#niveis').find('option:selected').val() == '3') {
    //     $('select.especializacoes').removeAttr('disabled')
    //     $('#especializacoes').removeAttr('hidden')
    //     $('select.especializacoes').prop('required',true);
    // } else {
    //     $('select.especializacoes').attr('disabled', 'disabled')
    //     $('#especializacoes').attr('hidden', 'hidden')
    // }

    $(document).on('click', '.add-tel', function() {
        if($('.tel').length < 4) {
            clonar('.tel', '#telefones', true)
            $('.tel').last().find('input').val('')
            $('.tel').last().find('.error').remove()
            mascararTel($('.tel').last().find('input'))
            $('.tel').last().find('.add-tel')
                .removeClass('add-tel')
                .addClass('del-tel')
                .find('i')
                .removeClass('fa fa-plus')
                .addClass('fa fa-trash')

            atualizaValidacoes('.telefone', telefoneRules)

        } else {
            alert('Podem ser adicionados no máximo '+$(".tel").length+' telefones')
        }
    })

    $(document).on("click", ".del-tel", function() {
        if($(".tel").length > 1) {
            remover(".tel", $(this))
        } else {
            alert('Deve conter no mínimo 1 telefone')
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
            alert('Podem ser adicionados no máximo '+$(".esp").length+' especializações')
        }
    })
    
    $(document).on("click", ".del-esp", function() {
        if($(".esp").length > 1) {
            remover(".esp", $(this))
        } else {
            alert('Deve conter no mínimo 1 especialização')
        }
    })
    
    $(document).on('click', '.add-doc', function() {
        if($('.doc').length < 10) {
            clonar('.doc', '#documentos', true)
            $('.doc').last().find('input').val('')
            $('.doc').last().find('.error').remove()
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
            alert('Podem ser adicionados no máximo '+$(".doc").length+' documentos')
        }
    })
    
    $(document).on("click", ".del-doc", function() {
        if($(".doc").length > 1) {
            remover(".doc", $(this))
        } else {
            alert('Deve conter no mínimo 1 documentos')
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

                    $(".cidades option").each(function() {
                        if($(this).text() == dados.localidade){
                            $(this).attr('selected', 'selected')
                        }
                    })

                    $("#logradouro").val(dados.logradouro);
                    $("#bairro").val(dados.bairro);
                    $("#numero").focus()
                }
            })
        }
    }
});

$(document).on('change', '#niveis', function() {
    if($(this).find('option:selected').val() == '3') {
        $('select.especializacoes').removeAttr('disabled')
        $('#especializacoes').removeAttr('hidden')
        $('select.especializacoes').prop('required',true);
    } else {
        $('select.especializacoes').attr('disabled', 'disabled')
        $('#especializacoes').attr('hidden', 'hidden')
    }
})

$(document).on('change', '#niveis', function() {
    if($(this).find('option:selected').val() == '3') {
        $('input.tempo_retorno').removeAttr('disabled')
        $('#tempo_retorno').removeAttr('hidden')
        $('input.tempo_retorno').prop('required',true);
    } else {
        $('input.tempo_retorno').attr('disabled', 'disabled')
        $('#tempo_retorno').attr('hidden', 'hidden')
    }
})

//ENDEREÇO
$('.estados').change(function() {
    atualizarCidades($(".estados option:selected").data("uf"), $(".estados").data('cidade'))
    $(".estados").data('cidade','')
})

function atualizarCidades(uf, selected_id = null) {
    $.ajax({
        url: main_url + "/usuario/get-cidades/"+uf,
        type: 'GET',
        success: function(data){
            $(".cidades option").remove();
            $(".cidades").append("<option value=''>Selecione</option>")
            $.each(data, function(i, cidade) {
                $(".cidades").append(`<option ${selected_id == cidade.id ? 'selected' : ''} value=${cidade.id}>${cidade.nome}</option>`)
            })
        }
    })
}

function selecionarCidade(cidade) {
    $(".cidades option").removeAttr('selected')
    $(".cidades option").each(function() {
        if($(this).text() == cidade){
            $(this).attr("selected", "selected")
        }
    })
}

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
