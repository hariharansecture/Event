<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Event </title>



  <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css"/>

 <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>


 <title>Datatables AJAX pagination with Search and Sort - Laravel 7</title>

    <!-- Meta -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('DataTables/datatables.min.css')}}">

    <!-- Script -->
    <script src="{{asset('jquery-3.6.0.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('DataTables/datatables.min.js')}}" type="text/javascript"></script>


    <!-- Datatables CSS CDN -->
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"> -->

    <!-- jQuery CDN -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->

    <!-- Datatables JS CDN -->
    <!-- <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script> -->

 <style>
   .container{
    padding: 0.5%;
   }
</style>
</head>
<body>

<div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            @if (Route::has('login'))
                <div class="col-sm-12 hidden fixed top-0 right-0 px-6 py-4 sm:block pull-right">
                    @auth
                    <div class="container">
                        <a href="{{ url('/home') }}" class="btn btn-primary float-right">Home</a>
                    </div>
                    @else
                    <div class="container">

                    <div class="float-right" >
                        <a href="{{ route('login') }}" class="btn btn-primary ">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-primary float-end">Register</a>
                        @endif
                        </div>
                    </div>
                    @endauth
                </div>
            @endif
</div>
<div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header"> View Average statistics</div>
                <div class="card-body">
                <a href="{{ route('view-statistics') }}" class="btn btn-primary" ><h4>Click here</h4></a>
                </div>

            </div>
        </div>
    </div>
<div class="container">
    <h2 style="margin-top: 12px;" class="alert alert-success">Event Listing</h2><br>

    <div class="row">
      <div class="col-md-2">Search by Date From</div>
      <div class="col-md-5">
       <div class="input-group input-daterange">
           <input type="date" name="from_date" id="from_date"  class="form-control" value="2022-05-05" />
           <div class="input-group-addon">&nbsp;to&nbsp;</div>
           <input type="date"  name="to_date" id="to_date"  class="form-control" value="2022-05-15" />
       </div>
      </div>
      <div class="col-md-2">
       <button type="button" name="filter" id="filter" class="btn btn-info btn-sm">Filter</button>
       <button type="button" name="refresh" id="refresh" class="btn btn-warning btn-sm">Refresh</button>
      </div>
     </div>
     <br>


    <div class="row">
        <div class="col-12">


          <table class="table table-bordered data-table" id="laravel_crud">
           <thead>
              <tr>

                 <th>Event Name</th>
                 <th>Start Date</th>
                 <th>End Date</th>
                 <th>Created By</th>

              </tr>
           </thead>
           <tbody id="posts-crud">

           </tbody>
          </table>

       </div>
    </div>
</div>

<br>


<script type="text/javascript">
    $(document).ready(function(){

      // DataTable
      $('#laravel_crud').DataTable({
        columnDefs: [ {
            sortable: false,
            "class": "index",
            targets: 0
        } ],
        order: [[ 1, 'asc' ]],
        fixedColumns: true,
         serverSide: true,
         ajax: "{{route('get-event')}}",
         columns: [

            { data: 'event_name' },
            { data: 'start_date' },
            { data: 'end_date' },
            { data: 'created_by' },
         ]
      });
    //   var table = $('#laravel_crud').DataTable();
    //   table.on( 'order.dt search.dt', function () {
    //     table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
    //         cell.innerHTML = i+1;
    //     } );
    // } ).draw();





 var _token = $('input[name="_token"]').val();

 fetch_data();

 function fetch_data(from_date = '', to_date = '')
 {
  $.ajax({
   url:"{{ route('daterange.fetch_data') }}",
   method:"POST",
   data:{from_date:from_date, to_date:to_date, _token: "{{ csrf_token() }}"},
   dataType:"json",
   success:function(data)
   {
    var output = '';
    $('#total_records').text(data.length);
    for(var count = 0; count < data.length; count++)
    {
     output += '<tr>';
     output += '<td>' + data[count].event_name + '</td>';
     output += '<td>' + data[count].start_date + '</td>';
     output += '<td>' + data[count].end_date + '</td>';
     output += '<td>' + data[count].created_by + '</td></tr>';
    }
    $('tbody').html(output);
   }
  })
 }

 $('#filter').click(function(){
  var from_date = $('#from_date').val();
  var to_date = $('#to_date').val();
  if(from_date != '' &&  to_date != '')
  {
   fetch_data(from_date, to_date);
  }
  else
  {
   alert('Both Date is required');
  }
 });

 $('#refresh').click(function(){
  $('#from_date').val('');
  $('#to_date').val('');
  fetch_data();
 });


    });





</script>



    </body>
</html>
