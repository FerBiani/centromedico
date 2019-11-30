@component('mail::message')
# Olá, {{explode(' ',$nomePaciente)[0]}}

Uma consulta da especialidade {{$especialidade}} está disponível, 
entre em contato com a clínica para agendar uma consulta.


Obrigado,<br>
{{ config('app.name') }}
@endcomponent
