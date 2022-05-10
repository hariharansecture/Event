<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Event;
use App\Http\Controllers\Redirect;
use App\Http\Requests\EventRequest;
use App\Services\HelperService;
use DataTables;
use App\Models\Invitation;
use App\Models\InvitedUsers;
use App\Mail\InviteCreated;
use App\Models\invitation as ModelsInvitation;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function createEvent()
    {
        return view('create-event');
    }

    public function inviteEvent()
    {
        $event = Event::where('created_by', Auth::user()->name)->pluck('id','event_name');
        //dd($event);
        return view('invite',compact('event'));
    }

    public function sendInvite(Request $request)
    {
        //dd($request->all());
        do {
            //generate a random string using Laravel's str_random helper
            $token = \Str::random(12);
        } //check if the token already exists and if it does, try again
        while (Invitation::where('token', $token)->first());
        //create a new invite record
        $invite = Invitation::create([
            'event_id' => $request->get('event_id'),
            'email' => $request->get('email'),
            'token' => $token,
            'created_by' => Auth::user()->name
        ]);
        // send the email
        Mail::to($request->get('email'))->send(new InviteCreated($invite));
        // redirect back where we came from
        return redirect()
            ->back();
    }

    public function acceptInvite($token){
        if (!$invite = Invitation::where('token', $token)->first()) {
            //if the invite doesn't exist do something more graceful than this
            abort(404);
        }

        //dd($invite);
        // create the user with the details from the invite
        InvitedUsers::create(['invited_email' => $invite->email,'invitation_created_by'=>$invite->created_by]);
        // delete the invite so it can't be used again
        $invite->delete();
        // here you would probably log the user in and show them the dashboard, but we'll just prove it worked
        return 'Good job! Invite accepted!';
    }


    public function viewInvitation()
    {
        $invited_users= InvitedUsers::where('invitation_created_by',Auth::user()->name)->pluck('invited_email');

        //dd($invited_users);
       return view('view_invitation',compact('invited_users'));
    }


    public function deleteInvite($email)
    {
        //dd($email);
       $delete = InvitedUsers::where('invited_email',$email)->delete();
       return response()->json(array('success' => 'true'));
        //dd($stock);

    }



    public function SaveEvent(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'event_name' => 'required|string',
            'start_date'    => 'required|date',
            'end_date'      => 'required|date|after_or_equal:start_date',
        ]);
        if ($validator->fails()) {
            return response()->json(array("errors"=>$validator->errors()), 422);
        }

        $createdBy = Auth::user()->name;
        return Event::create([
            'event_name' => $request['event_name'],
            'start_date' => $request['start_date'],
            'end_date' => $request['end_date'],
            'created_by' => $createdBy,
            'created_at' => \Carbon::now(),
        ]);
    }
}
