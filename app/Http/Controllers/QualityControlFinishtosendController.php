<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bill_detail;
use App\Employee;
use App\Customer;
use Carbon\Carbon;

class QualityControlFinishtosendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $today = Carbon::today();
        $bill_details_qc = Bill_detail::where('status', '=', 5) -> orwhere('status', '=', 6) ->get();
        $bill_details_finish_to_pack_count = count($bill_details_qc);

        $today = Carbon::today();
        $wait_qc_count = Bill_detail::where('status', '=', 2) -> count();
        $wait_to_pack = Bill_detail::where('status', '=', 3) -> orwhere('status', '=', 4) ->count();
        $wait_to_send = $bill_details_finish_to_pack_count;
        $reject_coute = Bill_detail::where('status', '=', 9) -> count();

        return view('qualitycontrol.finishtosend', compact('bill_details_finish_to_pack_count', 'bill_details_qc', 'wait_qc_count', 'wait_to_pack','reject_coute', 'wait_to_send'));
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
        //
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
