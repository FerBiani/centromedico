<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HorarioCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return [
            'horario.dia_semana' => 'required',
            'horario.tipo' => 'required',
            'horario.especializacoe_id' => 'required',
            'horario.duracao' => 'duracao',
            'horario.inicio' => 'required|date_format:H:i',
            'horario.fim' => 'required|gt:horario[inicio]'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
