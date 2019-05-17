<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioCreateRequest extends FormRequest
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
            'telefone.*.numero'             => 'required|size:14'
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
}
