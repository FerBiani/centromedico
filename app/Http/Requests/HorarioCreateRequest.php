<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HorarioCreateRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'horario.dia_semana' => ['required'],
            'horario.tipo' => ['required_with: horario.duracao'],
            'horario.especializacao_id' => ['required'],
            'horario.duracao' => ['required_with: horario.tipo', 'required_if:horario.tipo,==,2'],
            'horario.inicio' => ['required', 'before:horario.fim', 'date_format:H:i'],
            'horario.fim' => ['required', 'after:horario.inicio', 'date_format:H:i']
        ];
    }

    public function messages(){
        return [
            'required' => 'Este campo é obrigatorio',
            'required_if' => 'Este campo é obrigatorio',
            'required_with' => 'Este campo é obrigatorio',
            'date_format' => 'Horário inválido',
            'after'    => 'Este horário deve ser maior que a hora inicial',
            'before'    => 'Este horário deve ser menor que a hora final',
        ];
    }
}
