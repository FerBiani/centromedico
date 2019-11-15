<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
    <title>Document</title>
</head>
<body>
   <div class="container mt-5">
   <div class="card">
        <div class="card-header">Relatório da programação diária de pacientes</div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="usuario-table" class="table table-hover">
                    <thead class="thead thead-light">
                        <tr>
                            <th>Paciente</th>
                            <th>Inicio</th>
                            <th>Fim</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($consultas as $consulta)
                            <tr>
                                <td>{{\App\Usuario::find($consulta->paciente_id)->nome}}</td>
                                <td>{{ $consulta->inicio }}</td>
                                <td>{{ $consulta->fim }}</td> 
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
   </div>
</body>
<script>
    window.print()
</script>
</html>