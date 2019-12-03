<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipoDocumentoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'tipo_documentos.tipo' => ['required', 'unique:tipo_documentos,tipo,'.$this->route('tipo_documento').',id'],
            'tipo_documentos.possui_complemento' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'required'                              => 'Este campo é obrigatorio',
            'unique'                                => 'O valor informado neste campo já está em uso'
        ];
    }

}
