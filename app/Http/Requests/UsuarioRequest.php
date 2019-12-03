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
            'usuario.nome'                        => 'required|max:100',
            'usuario.email'                       => 'required|email|unique:usuarios,email,'.$this->route('usuario').',id',
            'usuario.password'                    => 'required_if:'.$this->route('usuario').',!==,null|min:6|max:10',
            'usuario.password_confirmation'       => 'required_if:'.$this->route('usuario').',!==,null|same:usuario.password',
            'usuario.nivel_id'                    => 'required',
            'especializacoes.*.especializacao_id' => 'required_if:usuario.nivel_id,==,3',
            'especializacoes.*.tempo_retorno'     => 'required_if:usuario.nivel_id,==,3|integer|min:0',
            'endereco.cep'                        => 'required',
            'endereco.estado_id'                  => 'required',
            'endereco.bairro'                     => 'required|max:100',
            'endereco.logradouro'                 => 'required|max:100',
            'endereco.numero'                     => 'required|numeric',
            'endereco.complemento'                => 'max:255',
            'telefone.*.numero'                   => 'required|min:14|max:15',
            'documento.*.tipo_documentos_id'      => 'required',
            'documento.*.numero'                  => 'required',
            'crm.numero'                          => 'required_if:usuario.nivel_id,==,3'
        ];
    }

    public function messages(){
        return [
            'required'                              => 'Este campo é obrigatorio',
            'required_if'                           => 'Este campo é obrigatorio',
            'required_with'                         => 'Este campo é obrigatorio',
            'unique'                                => 'O valor informado neste campo já está em uso',
            'integer'                               => 'Este campo deve conter um valor numérico',
            'email'                                 => 'Este campo deve conter um endereço de e-mail válido',
            'especializacoes.*.tempo_retorno.min'   => 'Este campo deve conter um valor maior ou igual a :min',
            'min'                                   => 'Este campo deve conter no mínimo :min caracteres',
            'max'                                   => 'Este campo deve conter no máximo :max caracteres',
            'numeric'                               => 'Este campo deve conter apenas números'
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
