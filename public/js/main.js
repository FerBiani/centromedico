$(document).ready(function() {
    //INSERINDO OS BOTÕES DE DELETAR NO CARREGAMENTO DA PÁGINA
    let newSufix = ""
    $('span[class*="add-"]').each(function(i, e) {
        let sufix = $(e).attr('class').match('add-[^-]*$')[0].split('-')[1]
        if(sufix !== newSufix) {
            i = 0
        }
        if(i > 0) {
            $(e).removeClass('add-'+sufix)
                .addClass('del-'+sufix)
                .find('i')
                .removeClass('fa-plus')
                .addClass('fa-trash') 
        }
        newSufix = sufix
    })

    if($('#niveis').find('option:selected').val() == '3') {
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
        $('select.especializacoes').removeAttr('disabled')
        $('#especializacoes').removeAttr('hidden')
        $('select.especializacoes').prop('required',true);
    } else {
        $('select.especializacoes').attr('disabled', 'disabled')
        $('#especializacoes').attr('hidden', 'hidden')
    }
})

function clonar(target, local, indices) {
    $(target).last().clone().appendTo(local)

    if(indices) {
        $(target).last().find('input, select').each(function() {
            var index = $(this).attr('name').split('[')[1].split(']')[0]
            $(this).attr('name', $(this).attr('name').replace(index, parseInt(index) + 1))
        })
    }
}

function remover(target, buttonClicked) {
    $(buttonClicked).closest(target).fadeOut('fast').remove()
}

$(document).on('click', '.add-tel', function() {
    if($('.tel').length < 4) {
        clonar('.tel', '#telefones', true)
        $('.tel').last().find('input').val('')
        mascararTel($('.tel').last().find('input'))
        $('.tel').last().find('.add-tel')
            .removeClass('add-tel')
            .addClass('del-tel')
            .find('i')
            .removeClass('fa fa-plus')
            .addClass('fa fa-trash')
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
        $('.doc').last().find('.add-doc')
            .removeClass('add-doc')
            .addClass('del-doc')
            .find('i')
            .removeClass('fa fa-plus')
            .addClass('fa fa-trash')
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

$(document).on('click', '.send-form', function() {
    if($("#form").valid()){
        $(".send-form").prop("disabled",true) 
        $("#form").submit()
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

//MEDICO/especializacoes
$('.especialidade').change(function() {
    atualizarMedicos($(".especialidade option:selected").data("especializacao"), $(".especialidade").data('medico'))
    $(".especialidade").data('medico','')
})

function atualizarMedicos(especializacao, selected_id = null) {
    $.ajax({
        url: main_url + "/get-medicos/"+especializacao,
        type: 'GET',
        success: function(data){
            $(".medicos option").remove();
            $(".medicos").append("<option value=''>Selecione</option>")
            $.each(data, function(i, medico) {
                $(".medicos").append(`<option ${selected_id == medico.id ? 'selected' : ''} value=${medico.id}>${medico.nome}</option>`)
            })
        }
    })
}

function selecionarMedico(medico) {
    $(".medicos option").removeAttr('selected')
    $(".medicos option").each(function() {
        if($(this).text() == medico){
            $(this).attr("selected", "selected")
        }
    })
}

function selecionarEspecializacao(especializacao) {
    $(".especialidade option").removeAttr('selected')
    $(".especialidade option").each(function() {
        if($(this).data("especializacao") == especializacao){
            $(this).attr('selected', 'selected')
        }
    })
}

//datas e horario disponiveis do medico
$('.medicos').change(function() {
    atualizarDias($(".medicos option:selected").val(), $(".medicos").data('data'))
    $(".medicos").data('data','')
})

function atualizarDias(medico, selected_id = null) {
    $.ajax({
        url: main_url + "/pacientes/dias/"+medico,
        type: 'GET',
        success: function(data){
            $(".dias option").remove();
            $(".dias").append("<option value=''>Selecione</option>")
            $.each(JSON.parse(data), function(i, dia) {
                $(".dias").append(`<option ${selected_id == dia ? 'selected' : ''} value=${dia.dia_semana}>${dia.dia_semana == 1 ? 'Segunda-feira': 'Terça-Feira'}</option>`)
                
            })
        }
    })
}


//MÁSCARAS
function mascararTel(input) {
    $(input).last().mask('(00) 0000-00009');
    $(input).last().keyup(function(event) {
        if($(this).val().length == 15){
                $(input).last().mask('(00) 00000-0009');
        } else {
                $(input).last().mask('(00) 0000-00009');
        }
    });
} 

$('.cep').mask('00000-000')
$('.telefone').each(function(i,tel){
    mascararTel(tel)
})

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
        "endereco[complemento]": { required: true, maxlength:255 },
        "telefone[numero]": { required: true, minlength:10, maxlength:11 },
        "documentos[tipo_documentos_id]": { required: true },
        "documentos[numero]": { required: true }

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

        "endereco[complemento]": { 
            required: 'Este campo é obrigatório' 
        },

        "telefone[numero]": { 
            required: 'Este campo é obrigatório',
            minlength: 'Este campo deve ter pelo menos 10 caracteres',
            maxlength: 'Este campo não pode passar de 11 caracteres'
        },
    },
});
