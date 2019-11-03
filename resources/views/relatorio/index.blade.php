@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-6">
       <div class="card mt-3">
            <div class="card-header">Gráfico</div>
            <div class="card-body">
                <canvas id="myChart" width="400" height="400"></canvas>
            </div>
        </div>
    </div>
    <!-- ////////////////////////// -->
    <div class="col-md-6">
        <div class="card text-white bg-primary shadow mt-3">
            <div class="card-body">
                <p class="text-center h4 my-0">Confirmados  <i class="fas fa-user-check"></i></p>
                <p class="text-center h2 my-0">
                    {{$data['agendamentos']['confirmados']}}
                    
                </p>
            </div> 
        </div>
        <div class="card text-white bg-danger shadow mt-4">
            <div class="card-body">
            <p class="text-center h4 my-0">Cancelados  <i class="far fa-window-close"></i></p>
                <p class="text-center h2 my-0">
                    {{$data['agendamentos']['cancelados']}}
                    
                </p>
            </div> 
        </div>
        <div class="card text-white bg-dark shadow mt-4">
            <div class="card-body">
            <p class="text-center h5 my-0">Não compareceu <i class="fas fa-user-slash"></i></p>
                <p class="text-center h2 my-0">
                    {{$data['agendamentos']['naoCompareceu']}}
                </p>
            </div> 
        </div>
        <div class="card text-white bg-success shadow mt-4">
            <div class="card-body">
            <p class="text-center h4 my-0">Finalizado  <i class="far fa-check-circle"></i></p>
                <p class="text-center h2 my-0">
                    {{$data['agendamentos']['finalizados']}}
                </p>
            </div> 
        </div>
    </div>
    </div>
</div>
@endsection
@section('js')
<script>
   $("#form").submit(function(e) {
        e.preventDefault(); 
        var form = $(this);
        $.ajax({
            type: "GET",
            url: "{{ url('usuario/status') }}",
            data: form.serialize(), 
            success: function(data)
            {
                console.log(data); 
            }
            });
        });

        // CHART
        var ctx = document.getElementById('myChart');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Confirmados', 'Cancelados', 'Não Compareceu','Finalizados'],
                datasets: [{
                    label: '# agendamentos',
                    data: [{{$data['agendamentos']['confirmados']}}, {{$data['agendamentos']['cancelados']}}, {{$data['agendamentos']['naoCompareceu']}}, {{$data['agendamentos']['finalizados']}}],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
</script>
@stop