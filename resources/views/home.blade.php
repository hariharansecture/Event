@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
        <div class="col-md-4">
        <div class="card" >
                <h2 class="card-header">{{ __('View Invited Users') }}</h2>
                <div class="card-body">
                <a href="{{ route('view-invite') }}" class="btn btn-primary" ><h3>View Invitation</h3></a>
                </div>
            </div>
        </div>
        <br><br><br><br><br><br>
        <div class="col-md-2">
        <div class="card" style="margin-left:-31em ;">
                <h2 class="card-header">{{ __('Event') }}</h2>
                <div class="card-body">
                <a href="{{ route('create-event') }}" ><h3>Click to Create Event</h3></a>
                </div>
            </div>
    </div>
    <div class="col-md-2">
        <div class="card" >
                <h2 class="card-header">{{ __('Invite') }}</h2>
                <div class="card-body">
                <a href="{{ route('invite-event') }}" class="btn btn-primary" ><h3>Invite by Email</h3></a>
                </div>
            </div>
    </div>
</div>
@endsection
