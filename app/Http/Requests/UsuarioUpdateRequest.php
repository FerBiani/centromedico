<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioUpdateRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'usuario.nome'                  => 'required|min:2|max:100',
            'usuario.email'                 => 'required|email',
            'endereco.cep'                  => 'required|numeric',
            'endereco.estado_id'            => 'required',
            'endereco.cidade'               => 'required',
            'endereco.bairro'               => 'required|max:100',
            'endereco.logradouro'           => 'required|max:100',
            'endereco.numero'               => 'required|numeric',
            'endereco.complemento'          => 'max:255',
            'telefone.*.numero'             => 'required|min:10|max:11',
            'documento.*.tipo_documentos_id' => 'required',
            'documento.*.numero'            => 'required'
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
