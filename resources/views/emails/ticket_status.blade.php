<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Status do Ticket</title>
</head>
<body>
	<p>
		Olá, {{ ucfirst($ticketOwner->name) }},
	</p>
	<p>
		Sua solicitação de suporte de ID #{{ $ticket->ticket_id }} 
		@if($ticket->status == 'Em andamento')
		foi lida e estamos trabalhando nisso. Assim que respondermos e/ou realizarmos alterações em seu projeto entramos em contato.
		@else
		foi marcada como resolvida e fechada.
		@endif
	</p>

	<p>
		Atenciosamente, {{$user->name}}<br>
		<b>Equipe Youniverse Web</b>

	</p>
</body>
</html>