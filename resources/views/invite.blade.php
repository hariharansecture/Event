
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"> Invite Users</div>

                <div class="card-body">
                <form action="{{ route('send-invite') }}" method="post">
                    {{ csrf_field() }}
                    <div class="col-md-12">
                        <select name="event_id" id="event_id" class="form-control">
                            <option value=0 selected>Select All</option>
                            @foreach($event as $data=>$id)
                            <option value={{$id}}>{{$data}}</option>
                            @endforeach
                        </select>
                    </div>
                    <br>
                    <input type="email" name="email" class="form-control" />
                    <br>
                    <button type="submit" class="btn btn-success">Send invite</button>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection






