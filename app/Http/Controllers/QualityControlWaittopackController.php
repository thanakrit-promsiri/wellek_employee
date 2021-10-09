<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bill_detail;
use App\Employee;
use App\Customer;
use Carbon\Carbon;

class QualityControlWaittopackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $today = Carbon::today();
        // $bill_details_query = Bill_detail::whereDate('time_to_qc', $today) -> get();
        $bill_details = Bill_detail::where('status', '=', 3)->orwhere('status', '=', 4) -> get();
        $bill_details_wait_to_pack_count = count($bill_details);

        $today = Carbon::today();
        $wait_qc_count = Bill_detail::where('status', '=', 2) -> count();
        $wait_to_pack = $bill_details_wait_to_pack_count;
        $wait_to_send = Bill_detail::where('status', '=', 5) -> orwhere('status', '=', 6) -> count();
        $reject_coute = Bill_detail::where('status', '=', 9) -> count();

        return view('qualitycontrol.waittopack', compact('bill_details', 'bill_details_wait_to_pack_count', 'wait_qc_count', 'wait_to_pack', 'wait_to_send','reject_coute'));
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
        $packer = Employee::where('emp_code', $request -> packer_id) -> first();

        $today = Carbon::now();
        $bill_details = Bill_detail::find($id);
        if($bill_details -> status == 3){
            $bill_details -> status = 4;
            $bill_details -> packer_id = $packer -> id;
            $bill_details -> start_to_pack = $today;
            $bill_details -> save();
        }else if($bill_details -> status == 4){
            $bill_details -> status = 5;
            $bill_details -> total = $request -> total;
            $bill_details -> total_parlate = $request -> total_parlate;
            $bill_details -> end_to_pack = $today;
            $bill_details -> save();
        }

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
