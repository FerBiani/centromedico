<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'usuario.nome'                     => 'required|max:100',
            'usuario.email'                    => 'required|email',
            'usuario.nivel_id'                 => 'required',
            'especializacoes.*.id'             => 'required_if:usuario.nivel_id,==,3',
            'especializacoes.*.tempo_retorno'  => 'required_if:usuario.nivel_id,==,3',
            'endereco.cep'                     => 'required',
            'endereco.estado_id'               => 'required',
            'endereco.bairro'                  => 'required|max:100',
            'endereco.logradouro'              => 'required|max:100',
            'endereco.numero'                  => 'required|numeric',
            'endereco.complemento'             => 'max:255',
            'telefone.*.numero'                => 'required|min:14|max:15',
            'documento.*.tipo_documentos_id'   => 'required',
            'documento.*.numero'               => 'required',
            'crm.numero'                       => 'required_if:usuario.nivel_id,==,3'
        ];
    }

    public function messages(){
        return [
            'required'      => 'Este campo é obrigatorio',
            'required_if'   => 'Este campo é obrigatorio',
            'required_with' => 'Este campo é obrigatorio',
            'email'         => 'Este campo deve conter um endereço de e-mail válido',
            'min'           => 'Este campo deve conter no mínimo :min caracteres',
            'max'           => 'Este campo deve conter no máximo :max caracteres',
            'numeric'       => 'Este campo deve conter apenas números'
        ];
    }

    public function filters()
    {
        return [
            'endereco.cep'      => 'digit',
            'telefone.*.numero' => 'digit'
        ];
    }
}
