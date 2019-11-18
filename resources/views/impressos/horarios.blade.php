<?php date_default_timezone_set('America/Sao_Paulo'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width", initial-scale="1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
    <link href="{{ asset('font/fontawesome/css/all.css') }}" rel="stylesheet" />
</head>
<body>
    <div class="container">
        <div class="card my-5">
            <div class="card-header">
                <h2 class="text-center">ATESTADO DE COMPARECIMENTO</h2>
            </div>
            <div class="card-body my-5">
                <div class="col-md-12 text-left">
                    <p>Atesto que o(a) Sr.(a) {{ \App\Usuario::find($consulta->paciente_id)->nome}} 
                    compareceu na Clínica Médica para uma consulta de {{ \App\Especializacao::find($consulta->especializacao_id)->especializacao }}
                    no dia {{ date('d/m/Y H:i',strtotime($consulta->inicio)) }} às {{ date('H:i', strtotime($consulta->fim)) }}.</p>
                </div>
                <div class="col-md-12 mt-5">
                    <div class="d-flex flex-row">
                        <div style="width: 25px; height: 25px; border:1px solid black"></div><span class="ml-2">Consulta</span> 
                    </div>
                    <div class="d-flex flex-row mt-4">
                        <div style="width: 25px; height: 25px; border:1px solid black"></div><span class="ml-2">Acompanhamento Familiar</span> 
                    </div>
                </div>
            </div>
            <div class="col-md-12 text-center mt-5">
                <p>___________________________________________________</p>
                <p class="small">{{ \App\Usuario::find($consulta->medico_id)->nome }} | CRM: {{\App\Usuario::find($consulta->medico_id)->documentos()->where('tipo_documentos_id', 4)->first()->numero}}</p>   
            </div>
        </div>
    </div>
    <script>
        window.print() 
    </script>
</body>
</html>