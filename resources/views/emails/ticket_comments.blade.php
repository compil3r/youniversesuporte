<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Resposta no Ticket</title>
</head>
<body>
	<p>
		{{ $comment->comment }}
	</p>

	---
	
	<p>Enviada por: {{ $user->name }}</p>

	<p>Titulo: {{ $ticket->title }}</p>
	<p>ID: #{{ $ticket->ticket_id }}</p>
	<p>Status: {{ $ticket->status }}</p>

	<p>
		Você pode ver esse ticket a todo momento aqui: {{ url('tickets/'. $ticket->ticket_id) }}
	</p>

</body>
</html>