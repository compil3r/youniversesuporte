@extends('layouts.app')

@section('title', 'Todas as solicitações')

@section('content')
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
	        <div class="panel panel-default">
	        	<div class="panel-heading">
	        		<i class="fa fa-ticket"> Tickets</i>
	        	</div>

	        	<div class="panel-body">
	        		@if ($tickets->isEmpty())
						<p>There are currently no tickets.</p>
	        		@else
		        		<table class="table">
		        			<thead>
		        				<tr>
		        					<th>Prioridade</th>
		        					<th>Categoria</th>
		        					<th>Titulo</th>
		        					<th>Status</th>
		        					<th>Solitação</th>
		        					<th>Ultima Atualização</th>
		        					<th style="text-align:center" colspan="2">Ações</th>
		        				</tr>
		        			</thead>
		        			<tbody>
		        			@foreach ($tickets as $ticket)
								<tr>
									<td>{{strtoupper($ticket->priority)}}</td>
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
		        					@elseif($ticket->status === 'Em andamento')
		        					<span class="label label-warning">{{ $ticket->status }}</span>
		        					@else
		        						<span class="label label-danger">{{ $ticket->status }}</span>
		        					@endif
		        					</td>
		        						<td>{{ $ticket->created_at->format('d-m-Y - H:m') }}</td>
		        					<td>{{ $ticket->updated_at->diffForHumans() }}</td>
		        					<td>
		        						<a href="{{ url('tickets/' . $ticket->ticket_id) }}" class="btn btn-primary">Responder</a>
		        					</td>
		        					@if($ticket->status == 'Aberto')
		        					<td>
		        						<form action="{{ url('admin/read_ticket/' . $ticket->ticket_id) }}" method="POST">
		        							{!! csrf_field() !!}
		        							<button type="submit" class="btn btn-warning">Trabalhar nisso</button>
		        						</form>
		        					</td>
		        					@elseif ($ticket->status == 'Em andamento')
		        					<td>
		        						<form action="{{ url('admin/close_ticket/' . $ticket->ticket_id) }}" method="POST">
		        							{!! csrf_field() !!}
		        							<button type="submit" class="btn btn-danger">Fechar</button>
		        						</form>
		        					</td>
		        					@elseif($ticket->status == 'Fechado')
		        					<td>
		        							<button type="submit" class="btn btn-disabled" disabled>Fechado</button>
		        					</td>
		        					@endif
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