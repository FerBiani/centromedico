<?php date_default_timezone_set('America/Sao_Paulo'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width", initial-scale="1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
</head>
<body>
        <div class="container">
            <div class="card my-5">
                <div class="card-header">
                    <h2 class="text-center">ATESTADO MÉDICO</h2>
                </div>
                <div class="card-body my-5">
                    <div class="col-md-12 text-left">
                        <p>Atesto que o(a) Sr.(a) <strong>{{$paciente->nome}}</strong> necessita 
                        de ________ dias de afastamento por motivos médicos.
                        </p>
                    </div>
                    <div class="col-md-12 text-left mt-5 mb-5">
                        <p>Descrição:</p>
                        <div style="height: 250px" class="border p-5"></div>
                    </div>
                    <div class="col-md-12 text-right">
                        _______________________________, {{date('d/m/Y H:i')}}
                    </div>
                    <div class="col-md-12 text-center mt-5">  
                        <p>________________________________</p>
                        <p class="small">{{Auth::user()->nome}} | CRM: {{Auth::user()->documentos()->where('tipo_documentos_id', 4)->first()->numero}}</p>
                    </div>
                </div>
            </div>
        </div>
    <script>
        window.print() 
    </script>
</body>
</html>