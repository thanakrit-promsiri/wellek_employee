<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bill_detail;
use App\Employee;
use App\Customer;
use Carbon\Carbon;

class QualityControlControler extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bill_details = Bill_detail::where('status', '=', 2) -> get();
        $bill_details_wait_to_qc_count = count($bill_details);
        $today = Carbon::today();
        $wait_qc_count = $bill_details_wait_to_qc_count;
        $wait_to_pack = Bill_detail::where('status', '=', 3) -> orwhere('status', '=', 4) ->count();
        $wait_to_send = Bill_detail::where('status', '=', 5) -> orwhere('status', '=', 6) -> count();
        $reject_coute = Bill_detail::where('status', '=', 9) -> count();

        return view('qualitycontrol.index', compact('bill_details', 'bill_details_wait_to_qc_count', 'wait_qc_count', 'wait_to_pack', 'wait_to_send','reject_coute'));
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
        // $packer = Employee::where('emp_code', $request -> packer_id) -> first();

        $today = Carbon::now();
        $authenticate_id = Session('authenticate') -> id;
        $bill_details = Bill_detail::find($id);
        $bill_details -> status = 3;
        $bill_details -> qc_id = $authenticate_id;
        $bill_details -> time_to_qc = $today;
        // $bill_details -> packer_id = $packer -> id;
        // $bill_details -> total = $request -> total;
        // $bill_details -> total_parlate = $request -> total_parlate;
        // $bill_details -> time_to_pack = $today;
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
