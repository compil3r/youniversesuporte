<?php

namespace App\Http\Controllers;

use App\User;
use App\Ticket;
use App\Category;
use App\Http\Requests;
use App\Mailers\AppMailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketsController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

    /**
     * Display all tickets.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$tickets = Ticket::orderBy('created_at', 'desc')->paginate(10);
        $categories = Category::all();
        if(Auth::user()->is_admin) {
            return view('tickets.index', compact('tickets', 'categories'));
        }
    }

    /**
     * Display all tickets by a user.
     *
     * @return \Illuminate\Http\Response
     */
    public function userTickets()
    {
        $tickets = Ticket::where('user_id', Auth::user()->id)->paginate(10);
        $categories = Category::all();

        return view('tickets.user_tickets', compact('tickets', 'categories'));
    }

    /**
     * Show the form for opening a new ticket.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$categories = Category::all();

        return view('tickets.create', compact('categories'));
    }

    /**
     * Store a newly created ticket in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, AppMailer $mailer)
    {
        $this->validate($request, [
            'title'     => 'required',
            'category'  => 'required',
            'priority'  => 'required',
            'message'   => 'required'
        ]);

        $ticket = new Ticket([
            'title'     => $request->input('title'),
            'user_id'   => Auth::user()->id,
            'ticket_id' => strtoupper(str_random(10)),
            'category_id'  => $request->input('category'),
            'priority'  => $request->input('priority'),
            'message'   => $request->input('message'),
            'status'    => "Aberto",
        ]);

        $ticket->save();

        $mailer->sendTicketInformation(Auth::user(), $ticket);

        return redirect()->to("tickets/$ticket->ticket_id")->with("status", "Sua solicitação foi enviada. Aguarde para ser respondido.");
    }

    /**
     * Display a specified ticket.
     *
     * @param  int  $ticket_id
     * @return \Illuminate\Http\Response
     */
    public function show($ticket_id)
    {

        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();

        $comments = $ticket->comments;

        $category = $ticket->category;
        
        if (Auth::user() && (Auth::user()->id == $ticket->user->id || Auth::user()->is_admin == 1)) {
           return view('tickets.show', compact('ticket', 'category', 'comments'));
        }
    }

    /**
     * Close the specified ticket.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function close($ticket_id, AppMailer $mailer)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();

        $ticket->status = 'Fechado';

        $ticket->save();

        $ticketOwner = $ticket->user;
        
        $user = Auth::user();

        $mailer->sendTicketStatusNotification($ticketOwner, $ticket, $user);

        return redirect()->back()->with("status", "Status alterado.");
    }

      public function read($ticket_id, AppMailer $mailer)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();

        $ticket->status = 'Em andamento';

        $ticket->save();

        $ticketOwner = $ticket->user;

        $user = Auth::user();

        $mailer->sendTicketStatusNotification($ticketOwner, $ticket, $user);

        return redirect()->back()->with("status", "Ticket foi fechado.");
    }
}
