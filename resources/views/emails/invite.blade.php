<p>Hi,</p>
<p>Someone {{$invite->email}} has invited you to participate the event.</p>
<a href="{{ route('accept', $invite->token) }}">Click here</a> to accept the invitation!
