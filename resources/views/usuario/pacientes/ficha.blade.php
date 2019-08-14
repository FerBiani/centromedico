@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">{{$data['title']}}</div>
            <div class="card-body">
            	<h5>Dados Pessoais</h5>
            	<hr>
            	<div class="row">
            		<div class="col-md-6">
            			<span><i class="fas fa fa-user"></i> {{ $data['usuario']->nome }}</span>
            		</div>
            		<div class="col-md-6">
            			<span><i class="fas fa fa-envelope"></i> {{ $data['usuario']->email }}</span>
            		</div>
            	</div>
            	<div class="row">
            		<div class="col-md-6">
            			@foreach($data['usuario']->telefones as $telefone)
			        		<span><i class="fas fa fa-phone-volume"></i> {{$telefone->numero ? $telefone->numero : '-'}}</span>
            			@endforeach
            		</div>
            	</div>

            	<h5 class="d-flex align-items-end mt-4">Dados Residenciais</h5>
            	<hr>
            	<div class="row">
            		<div class="col-md-6"><span><i class="fas fa fa-home"></i> {{ $data['usuario']->endereco->logradouro.' - '.$data['usuario']->endereco->cep.', '.$data['usuario']->endereco->bairro.', '.$data['usuario']->endereco->numero }}</span></div>
            	
            		<div class="col-md-6"><i class="fas fa fa-map-marker-alt"></i> {{ $data['usuario']->endereco->cidade->nome }} - {{ $data['usuario']->endereco->cidade->estado->uf }}</div>          		     	    
            	</div>

            	<h5 class="d-flex align-items-end mt-4">Documentos</h5>
            	<hr>
            	<div class="row">
            		<div class="col-md-6">
            			@foreach($data['usuario']->documentos as $documento)
            				<?php $tipoDocumento = \App\TipoDocumento::find($documento->tipo_documentos_id); ?>
 	           				<span><i class="fas fa fa-id-card"></i> {{$tipoDocumento->tipo.': '.$documento->numero }}</span>
            			@endforeach
            		</div>
            	</div>
            </div> 
        </div>
    </div>
</div>
@endsection
@section('js')
@endsection