<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConsultaCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'consulta.especializacoe_id' => 'required',
            'consulta.medico_id' => 'required',
            'consulta.data' => 'required',
            'consulta.hora' => 'required'
        ];
    }

    public function messages(){
        return [
            'required'      => 'Este campo é obrigatorio',
        ];
    }
}
