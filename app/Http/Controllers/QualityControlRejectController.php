<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bill_detail;
use App\Employee;
use App\Customer;
use App\Reject;
use DB;
use Carbon\Carbon;

class QualityControlRejectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $today = Carbon::today();
        // $data = DB::table("rejects")
	    // ->select(DB::raw("COUNT(*) as bill_id"))
	    // ->orderBy("created_at")
	    // ->groupBy(DB::raw("year(created_at)"))
        // ->get();

        // foreach($data as $data){
        //     $bill_details = Reject::where('id','=',$data->bill_id)->get();
        // }
        $bill_details = Reject::orderBy('created_at', 'desc')
                                ->get()
                                ->unique('bill_id');
        // $bill_details_modal = Reject::all();
        // dd($bill_details);

        $wait_qc_count = Bill_detail::where('status', '=', 2) -> count();
        $wait_to_pack = Bill_detail::where('status', '=', 3) -> orwhere('status', '=', 4) ->count();
        $wait_to_send = Bill_detail::where('status', '=', 5) -> orwhere('status', '=', 6) -> count();
        $reject_coute = Bill_detail::where('status', '=', 9) -> count();

        return view('qualitycontrol.reject.reject', compact('wait_qc_count', 'wait_to_pack', 'wait_to_send','reject_coute', 'bill_details'));
    }

    public function index_qc()
    {

        $today = Carbon::today();
        $bill_details = Reject::orderBy('created_at', 'desc')
                                ->get()
                                ->unique('bill_id');

        $wait_qc_count = Bill_detail::where('status', '=', 2) -> count();
        $wait_to_pack = Bill_detail::where('status', '=', 3) -> orwhere('status', '=', 4) ->count();
        $wait_to_send = Bill_detail::where('status', '=', 5) -> orwhere('status', '=', 6) -> count();
        $reject_coute = Bill_detail::where('status', '=', 9) -> count();

        return view('qualitycontrol.reject', compact('wait_qc_count', 'wait_to_pack', 'wait_to_send','reject_coute', 'bill_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $reject = Reject::find($id);
        $bill_id = $reject -> bill_id;
        $bill_details = Bill_detail::find($bill_id);
        $bill_details -> status = 2;
        $bill_details -> save();

        return redirect() -> back();
    }

    public function update_reject(Request $request)
    {
        $reject = Reject::find($request -> id);
        $bill_id = $reject -> bill_id;
        $bill_details = Bill_detail::find($bill_id);
        $bill_details -> status = 2;
        $bill_details -> save();

        return redirect() -> back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
