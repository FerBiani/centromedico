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
            'inicio' => ['required'],
            'fim'    => ['required'],
            'medico_id' => ['required'],
            'agendamento.especialidade' => ['required'],
            'paciente_id' => ['required'],
            'data' => ['required']
        ];
    }
}
