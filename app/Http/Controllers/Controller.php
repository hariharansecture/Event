<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Event;
use App\Http\Controllers\Redirect;
use App\Http\Requests\EventRequest;
use App\Services\HelperService;
use DataTables;
use DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function eventListing(Request $request)
    {
        $data = Event::orderBy('id','desc')->get();
        return view('welcome', compact('data'));

    }

    public function viewStatistics()
    {
        $avgEventForUser = Event::select('event_name','created_by')
        ->select(DB::raw('COUNT(event_name) as total_count,created_by'))
            ->groupBy('created_by')
            ->get();

        $avgUser = Event::select(DB::raw('COUNT(DISTINCT created_by) as total_count'))->get();
        return view('view-statistics',compact('avgEventForUser','avgUser'));
    }

    public function getEvent(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // total number of rows per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Event::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Event::select('count(*) as allcount')->where('event_name', 'like', '%' . $searchValue . '%')->count();

        // Get records, also we have included search filter as well
        $records = Event::orderBy($columnName, $columnSortOrder)
            ->where('events.event_name', 'like', '%' . $searchValue . '%')
            ->orWhere('events.start_date', 'like', '%' . $searchValue . '%')
            ->orWhere('events.end_date', 'like', '%' . $searchValue . '%')
            ->orWhere('events.created_by', 'like', '%' . $searchValue . '%')
            ->select('events.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {

            $data_arr[] = array(

                "event_name" => $record->event_name,
                "start_date" => $record->start_date,
                "end_date" => $record->end_date,
                "created_by" => $record->created_by,
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );

        echo json_encode($response);
    }

    function fetch_data(Request $request)
    {
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        if(isset($from_date) && isset($to_date)){
            $response = Event::when([$from_date !=null,$to_date !=null], function ($q) use ($from_date,$to_date) {

                $q->where('start_date','>=', $from_date);
                $q->where('end_date','<=', $to_date);

            });
            $response = $response->get();
            //$response = array();
            //dd($response);
            echo json_encode($response);
        }else{
            $response = Event::orderBy('id','desc')->get();
            echo json_encode($response);

        }

        //dd($response->get());

        //dd($response->get());

    }


}
