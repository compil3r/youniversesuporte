@extends('layouts.app')

@section('title', 'My Tickets')

@section('content')
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
	        <div class="panel panel-default">
	        	<div class="panel-heading">
	        		<i class="fa fa-ticket"> Minhas Solicitações</i>
	        	</div>

	        	<div class="panel-body">
	        		@if ($tickets->isEmpty())
						<p>Você não solicitou nada ainda.</p>
	        		@else
		        		<table class="table">
		        			<thead>
		        				<tr>
		        					<th>Categoria</th>
		        					<th>Titulo</th>
		        					<th>Status</th>
		        					<th>Data de Solicitação</th>
		        					<th>Ultima Atualização</th>
		        				</tr>
		        			</thead>
		        			<tbody>
		        			@foreach ($tickets as $ticket)
								<tr>
		        					<td>
		        					@foreach ($categories as $category)
		        						@if ($category->id === $ticket->category_id)
											{{ $category->name }}
		        						@endif
		        					@endforeach
		        					</td>
		        					<td>
		        						<a href="{{ url('tickets/'. $ticket->ticket_id) }}">
		        							#{{ $ticket->ticket_id }} - {{ $ticket->title }}
		        						</a>
		        					</td>
		        					<td>
		        					@if ($ticket->status === 'Aberto')
		        						<span class="label label-success">{{ $ticket->status }}</span>
		        					@elseif ($ticket->status === 'Em andamento')
		        						<span class="label label-Warning">{{ $ticket->status }}</span>
		        					@else
		        						<span class="label label-danger">{{ $ticket->status }}</span>
		        					@endif
		        					</td>
		        					<td>{{ $ticket->created_at->format('d-m-Y - H:m') }}</td>
		        					<td>{{ $ticket->updated_at->diffForHumans() }}</td>
		        				</tr>
		        			@endforeach
		        			</tbody>
		        		</table>

		        		{{ $tickets->render() }}
	        		@endif
	        	</div>
	        </div>
	    </div>
	</div>
@endsection