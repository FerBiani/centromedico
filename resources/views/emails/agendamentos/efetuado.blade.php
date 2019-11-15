@component('mail::message')
# Olá, {{explode(' ',$nomePaciente)[0]}}

Aqui estão as informações da sua consulta:

@component('mail::table')
| Especialidade       | Médico                   | Início           | *Código de Check-in |
|:--------------------|:-------------------------|:-----------------|:--------------------|
| {{$especialidade}}  | {{$nomeMedico}}          | {{$inicio}}      | {{$codigoCheckIn}}  |
@endcomponent

*No dia da consulta, insira este código no terminal disponível no consultório para efetuar o check-in.

@component('mail::button', ['url' => url('/')])
Acessar o site
@endcomponent

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
