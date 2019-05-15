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
            'usuario.nome'                  => 'required|max:100',
            'usuario.email'                 => 'required|email',
            'usuario.password'              => 'required|min:6|max:10',
            'usuario.nivel_id'              => 'required',
            'endereco.cep'                  => 'required',
            'endereco.estado_id'            => 'required',
            'endereco.cidade_id'            => 'required',
            'endereco.bairro'               => 'required|max:100',
            'endereco.logradouro'           => 'required|max:100',
            'endereco.numero'               => 'required|max:5',
            'endereco.complemento'          => 'max:255',
            'telefone.numero'               => 'required'
        ];
    }

    public function messages(){
        return [
            'required'      => 'Este campo é obrigatorio',
            'email'         => 'E email deve ser um endereço válido',
            'password'      => 'A senha deve conter pelo menos 6 caracteres',
        ];
    }
}
