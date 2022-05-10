<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <link id="bs-css" href="https://netdna.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link id="bsdp-css" href="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker3.min.css" rel="stylesheet">
</head>
<body>
@if (count($errors) > 0)
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="container" style="margin-top:5em;">
<div class="card">
<h2 class="card-header">{{ __('Create Event') }}</h2>


{{ Form::open(array('url'=>'#','id'=>'event_form','class'=>'form-horizontal', 'method'=> 'POST')) }}

{{ csrf_field() }}
<div class="card-body">
  <div class="form-group row mx-0">
            <div class="col-md-0" style="margin-top:7px;margin-left: 0px;">{{ __('Event Name') }}</div>
                <div class="col-sm-5" id="ev_name" style="margin-left:15px;">
                    <input type="text" id="event_name" name="event_name" class="form-control @error('event_name') is-invalid @enderror" />
                    @if($errors->has('event_name'))
                        <div class="error">{{ $errors->first('event_name') }}</div>
                    @endif
                </div>
  </div>

  <div class="form-group row mx-0">
            <div class="col-md-0" style="margin-top:7px;margin-left: 0px;">Start Date</div>
                <div class="col-sm-5" id="from_date" style="margin-left:25px;">
                    <input type="date" id="start_date" name="start_date" class="form-control" />
                    @error('start_date')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
  </div>
  <div class="form-group row mx-0">
            <div class="col-md-0" style="margin-top:7px;margin-left: 0px;">End Date</div>
                <div class="col-sm-5" id="to_date" style="margin-left:30px;">
                    <input type="date" id="end_date" name="end_date" class="form-control" />
                    @error('end_date')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
  </div>
  {{ Form::submit('Save', array('class'=>'btn btn-primary mb-2','id'=>'save_change'))}}
  {{ Form::close() }}

</div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>
<link href="/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <script type="text/javascript">
      $(document).ready(function(){
       $(".datepicker").datepicker({
            format: "dd/mm/yy",
            weekStart: 0,
            calendarWeeks: true,
            autoclose: true,
            todayHighlight: true,
            rtl: true,
            orientation: "auto"
            });
        });

    $('#event_form').submit(function (e) {
            e.preventDefault();
            var $form = $(this);
            $form.find('.form-group').removeClass('has-error').find('.help-block').text('');
            var formData = new FormData($('#event_form')[0]);
            var url= "{{route('save-event')}}";
            $.ajax({
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: 'POST',
                data: formData,
                success: function (data) {

                        console.log(data);
                        swal("Created", "Event creation successful", "success");
                        setTimeout(function() {
                            window.location.href = "{{ route('eventListing') }}";
                        }, 2000);

                },
                fail: function (response) {
                    console.log(response);
                    swal("Oops", "Something went wrong", "warning");
                },
                error: function (xhr, textStatus, thrownError,err) {
                    console.log(xhr.status);
                    console.log(xhr.responseJSON.errors);
                    var obj = xhr.responseJSON.errors;
                    console.log(obj[Object.keys(obj)[0]]);
                    swal("Oops",obj[Object.keys(obj)[0]], "error");
                },
                contentType: false,
                processData: false,

            });
        });
        </script>
</body>
</html>
