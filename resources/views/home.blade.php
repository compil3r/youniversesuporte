@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Painel</div>

                <div class="panel-body">
                    <p><strong>Bem vindo, {{ucfirst(Auth::user()->name)}}!</strong></p>

                    @if (Auth::user()->is_admin)
                        <p>
                            Veja todos os <a href="{{ url('admin/tickets') }}">tickets</a>.
                        </p>
                    @else
                        <p>
                            Veja os seus <a href="{{ url('my_tickets') }}">tickets</a> ou <a href="{{ url('new_ticket') }}">crie um novo ticket.</a>
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
