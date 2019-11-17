function clonar(target, local, indices) {
    let clone = $(target).last().clone()

    clone.find('input').val('').removeClass('is-valid').removeClass('is-invalid')
    clone.find('select').removeClass('is-valid').removeClass('is-invalid')
    clone.find('.error').remove()
    
    clone.appendTo(local)

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

$(document).on('click', '.send-form', function() {
    if($("#form").valid()){
        $(".send-form").prop("disabled",true) 
        $("#form").submit()
    }
})

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
})