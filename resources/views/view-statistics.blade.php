@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h4 class="card-header"> Average Event for Users</h4>
                <div class="card-body">
                @foreach($avgEventForUser as $data)
                    <h4>Totally &nbsp;&nbsp;{{$data->total_count}}&nbsp;&nbsp; Events Created by&nbsp;&nbsp;{{$data->created_by}}</h4>
                @endforeach
                </div>

            </div>
        </div>
        <br><br>
        <div class="col-md-8" style="margin-top: 2em;">
            <div class="card">
                <h4 class="card-header"> Average of Users</h4>
                <div class="card-body">
                @foreach($avgUser as $data)
                    <h4>Average number of users &nbsp;&nbsp;{{$data->total_count}}</h4>
                @endforeach
                </div>

            </div>
        </div>

        <div class="col-sm-2" style="margin-top: 2em;">
        <div class="card" >
                <h4 class="card-header">{{ __('Go Back') }}</h4>
                <div class="card-body">
                <a href="{{ route('eventListing') }}" class="btn btn-primary" ><h4>Click here</h4></a>
                </div>
            </div>
    </div>
    </div>
</div>
@endsection
