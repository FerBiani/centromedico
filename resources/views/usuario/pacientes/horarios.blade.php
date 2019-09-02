@extends('layouts.app')
@section('content')
<style>

      #calendar {
        max-width: 600px;
      }
      .col-centered{
        float: none;
        margin: 0 auto;
      }
    </style>
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">{{$data['title']}}</div>
            <div class="card-body">
			<div id="calendar" class="col-centered"></div>
        	</div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>

	$(document).ready(function() {
		
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek,basicDay',
				
				
			},
			locale: 'pt-br',
			defaultDate: '2016-01-12',
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			selectable: true,
			selectHelper: true,
			select: function(start, end) {
				
				$('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
				$('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
				$('#ModalAdd').modal('show');
			},
			eventRender: function(event, element) {
				element.bind('dblclick', function() {
					$('#ModalEdit #id').val(event.id);
					$('#ModalEdit #title').val(event.title);
					$('#ModalEdit #color').val(event.color);
					$('#ModalEdit').modal('show');
				});
			},
			eventDrop: function(event, delta, revertFunc) { // si changement de position

				edit(event);

			},
			eventResize: function(event,dayDelta,minuteDelta,revertFunc) { // si changement de longueur

				edit(event);

			},
			events: [
			<?php foreach($data['consultas'] as $consulta): 
			
				$start = explode(" ", $consulta['inicio']);
				$end = explode(" ", $consulta['fim']);
				if($start[1] == '00:00:00'){
					$start = $start[0];
				}else{
					$start = $consulta['inicio'];
				}
				if($end[1] == '00:00:00'){
					$end = $end[0];
				}else{
					$end = $consulta['fim'];
				}
			?>
				{
					id: '<?php echo $consulta['id']; ?>',
					title: '<?php echo $consulta->especializacoes()->get()[0]->especializacao;?>',
					start: '<?php echo $start; ?>',
					end: '<?php echo $end; ?>'
				},
			<?php endforeach; ?>
			]
		});
		
		function edit(event){
			start = event.start.format('YYYY-MM-DD HH:mm:ss');
			if(event.end){
				end = event.end.format('YYYY-MM-DD HH:mm:ss');
			}else{
				end = start;
			}
			
			id =  event.id;
			
			Event = [];
			Event[0] = id;
			Event[1] = start;
			Event[2] = end;
			
			$.ajax({
			 url: 'editEventDate.php',
			 type: "POST",
			 data: {Event:Event},
			 success: function(rep) {
					if(rep == 'OK'){
						alert('Saved');
					}else{
						alert('Could not be saved. try again.'); 
					}
				}
			});
		}
		
	});

</script>
@endsection