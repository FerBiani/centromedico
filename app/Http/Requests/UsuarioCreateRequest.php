<?php

namespace App\Http\Requests;

class UsuarioCreateRequest extends BaseFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'usuario.nome'                  => 'required|max:100',
            'usuario.email'                 => 'required|email',
            'usuario.password'              => 'required|min:6|max:10',
            'usuario.password_confirmation' => 'required|same:usuario.password',
            'usuario.nivel_id'              => 'required',
            'endereco.cep'                  => 'required',
            'endereco.estado_id'            => 'required',
            'endereco.cidade_id'            => 'required',
            'endereco.bairro'               => 'required|max:100',
            'endereco.logradouro'           => 'required|max:100',
            'endereco.numero'               => 'required|numeric',
            'endereco.complemento'          => 'max:255',
            'telefone.*.numero'             => 'required|min:10|max:11',
            'documentos.tipo_documentos_id' => 'requried',
            'documentos.numero'             => 'required|numeric'
        ];
    }

    public function messages(){
        return [
            'required'      => 'Este campo é obrigatorio',
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
