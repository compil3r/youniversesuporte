<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<title>Informações de solicitação</title>
</head>
<body>
	<p>
		Obrigado, {{ ucfirst($user->name) }} por enviar a sua solicitação para nossa equipe. Um ticket de suporte foi aberto para você. Você será sempre notificado por este e-mail. Você pode observar os detalhes do seu ticket abaixo:
	</p>

	<p>Titulo: {{ $ticket->title }}</p>
	<p>Prioridade: {{ $ticket->priority }}</p>
	<p>Status: {{ $ticket->status }}</p>

	<p>
		Você pode ver esse ticket a todo o momento em: {{ url('tickets/'. $ticket->ticket_id) }}
	</p>

</body>
</html>