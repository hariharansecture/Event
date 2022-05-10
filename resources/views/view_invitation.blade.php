
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"> Invited Users</div>

                {{ csrf_field() }}
                <div class="card-body">
                @foreach($invited_users as $data)
                    <div>{{$data}}&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-success invite" value="{{$data}}">Delete</button></div>
                @endforeach
                </div>

            </div>
        </div>
        <div class="col-sm-2">
        <div class="card" >
                <h4 class="card-header">{{ __('Go Back') }}</h4>
                <div class="card-body">
                <a href="{{ route('home') }}" class="btn btn-primary" ><h4>Click here</h4></a>
                </div>
            </div>
    </div>
    </div>
</div>

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script>
     $(function () {
    $('.invite').on('click',  function (e) {
            var id = $(this).val();
            console.log(id);
            var base_url = "{{ route('delete-invite',':id') }}";
            var url = base_url.replace(':id', id);
            swal({
                    title: "Are you sure?",
                    text: "You will not be able to undo this action. Proceed?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, remove",
                    showLoaderOnConfirm: true,
                    closeOnConfirm: false
                },
                function () {
                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function (data) {
                            if (data.success) {

                                swal("DELETED", "Invitation deleted successfully", "warning");
                                setTimeout(function() {
                                    window.location.href = "{{ route('home') }}";
                                }, 2000);
                            }
                        },

                        contentType: false,
                        processData: false,
                    });
                });
                });
            });
</script>






