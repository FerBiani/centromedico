<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgendamentoRequest extends FormRequest
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
            'agendamento.inicio' => ['required'],
            'agendamento.fim'    => ['required'],
            'agendamento.medico_id' => ['required'],
            'agendamento.especializacao_id' => ['required'],
            'agendamento.paciente_id' => ['required'],
            'agendamento.data' => ['required']
        ];
    }

    public function messages(){
        return [
            'required'      => 'Este campo é obrigatorio',
        ];
    }
}
