<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListaEsperaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'lista.paciente_id' => ['required_with: horario.duracao'],
            'lista.dia_semana_id' => ['required'],
            'lista.especializacao_id' => ['required'],
        ];
    }

    public function messages(){
        return [
            'required' => 'Este campo é obrigatorio',
        ];
    }
}
