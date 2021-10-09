@extends('layouts.master')

@section('title', 'ตรวจสอบสินค้า')

@section('stylesheet')
  <style>
    .wrapper {
      margin: 10px;
    }
    .wrapper_modal {
      padding: 10px;
    }
    .box-detail {
      position: relative;
      border: 1px solid black;
      border-radius: 5px;
      padding: 10px;
    }
    hr {
      padding: 0;
      margin-top: 18px;
      margin-bottom: 18px;
    }
    .center {
        text-align: center;
    }
    .form-margin {
      margin-top: 5px;
      margin-bottom: 5px;
    }
    .control-label {
      margin-top: 5px;
    }
    hr {
      margin-top: 12px;
      margin-bottom: 12px;
    }
    button {
        background-color: Transparent;
        background-repeat:no-repeat;
        border: none;
        cursor:pointer;
        overflow: hidden;
        outline:none;
        color: #337ab7;
    }
  </style>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12 col-sm-12 form__responsive">
      <div class="row">
        <div class="col-md-9 col-sm-7">
          <label style="font-size: 19px;">รายการที่ต้องแก้ไข<span>&nbsp;&nbsp; {{$reject_coute}} &nbsp;&nbsp;รายการ</span></label>
        </div>
        {{-- @if($bill_details_finish_to_pack_count != 0)
            <div class="col-md-3 col-sm-5" align="right">
                <div class="wlp_link">
                    <a href="{{ url('qc-label') }}" target="_blank" style="text-decoration: none;"><i class="fas fa-print" style="font-size: 17px;"></i>&nbsp;พิมพ์หน้านี้</a>
                </div>
            </div>
        @endif --}}
      </div>
      <hr>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <table id="example" class="display">
        <thead>
            <tr>
                <th>&nbsp;</th>
                <th width="16%">เวลาเปิดบิล</th>
                <th>เลขที่บิล</th>
                <th width="15%">รหัสลูกค้า</th>
                <th>ชื่อลูกค้า</th>
                {{-- <th width="16%">เวลาที่ส่งแก้ไข</th> --}}
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            @php($no = 1)
            @foreach($bill_details as $row_bill_details)
            @if($row_bill_details -> get_bill -> status == 9)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $row_bill_details -> get_bill -> time_to_start -> format('H:i:s') . " น." }}</td>
                    <td>{{ $row_bill_details -> get_bill -> bill_code }}</td>
                    <td>{{ $row_bill_details -> get_bill -> get_customer -> cus_code }}</td>
                    <td>{{ $row_bill_details -> get_bill -> get_customer -> cus_name }}</td>
                    {{-- <td>{{ $row_bill_details -> created_at -> format('H:i:s') . " น." }}</td> --}}
                    <td align="center"><a href="#ModalReject" data-toggle="modal" data-target="#ModalReject{{ $row_bill_details -> id }}" data-backdrop="static" data-keyboard="false" class="reject"><i class="fas fa-search" style="font-size: 17px;"></i></a></td>
                </tr>
            @endif
            @endforeach
        </tbody>
      </table>
      @if(isset($bill_details))
      @foreach($bill_details as $row_bill_details)
        <div id="ModalReject{{ $row_bill_details -> id }}" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close reset-interval" data-dismiss="modal">&times;</button>
                  <h5 class="modal-title" style="font-weight: bold;">รายละเอียดบิล&nbsp;&nbsp;:&nbsp;&nbsp;{{ $row_bill_details -> get_bill -> bill_code }}</h5>
                </div>
                <div class="modal-body">
                      {{-- <table class="custom_table">
                        <tr>
                          <th width="11%">รหัสลูกค้า</th>
                          <th width="35%">ชื่อลูกค้า</th>
                          <th width="18%">เลขที่บิล</th>
                          <th width="15%">เวลาที่ส่งแก้ไข</th>
                          <th width="30%">หมายเหตุ</th>
                        </tr>
                        @foreach($bill_details_modal as $key => $row)
                            @if($row -> get_bill -> id == $row_bill_details -> get_bill -> id)
                            <tr>
                                <td>{{ $row -> get_bill -> get_customer -> cus_code }}</td>
                                <td>{{ $row -> get_bill -> get_customer -> cus_name }}</td>
                                <td>{{ $row -> get_bill -> bill_code }}</td>
                                <td>{{ $row -> created_at -> format('H:i:s') . " น." }}</td>
                                <td>{{ $row -> reject_description }}</td>
                            </tr>
                            @endif
                        @endforeach
                      </table> --}}
                    <div class="wrapper_modal">
                        <div class="row">
                        <div class="col-md-6 form-margin">
                            <div class="form-group">
                            <label class="control-label col-sm-3" for="">สาย :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="" value="{{ $row_bill_details -> get_bill -> get_customer_route -> get_route -> route_code }}" readonly>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-6 form-margin">
                            <div class="form-group">
                            <label class="control-label col-sm-3" for="">เลขที่บิล :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="" value="{{ $row_bill_details -> get_bill -> bill_code }}" readonly>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-6 form-margin">
                            <div class="form-group">
                            <label class="control-label col-sm-3" for="">รหัสลูกค้า :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="" value="{{ $row_bill_details -> get_bill -> get_customer -> cus_code }}" readonly>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-6 form-margin">
                            <div class="form-group">
                            <label class="control-label col-sm-3" for="">ชื่อลูกค้า :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="" value="{{ $row_bill_details -> get_bill -> get_customer -> cus_name }}" readonly>
                            </div>
                            </div>
                        </div>
                        <form method="POST" action="{{ url('quality-control-rejects-update?id='.$row_bill_details -> id) }}">
                            @csrf
                            <div class="col-md-12 form-margin" align="right">
                                <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-success" style="margin-top: 12px;"><i class="fas fa-clipboard-check"></i>&nbsp;&nbsp;ยืนยันการแก้ไข</button>
                                    <button class="btn btn-default reset-interval" data-dismiss="modal" aria-hidden="true" style="margin-top: 12px;">ปิด</button>
                                </div>
                                </div>
                            </div>
                        </form>
                        <div class="col-md-12">
                            <hr>
                        </div>
                        <div class="col-md-12">
                            <div class="reject-wrapper">
                            <div class="reject-box">
                                <div class="row">
                                <div class="col-md-12 form-margin">
                                    <div class="form-group">
                                    <label class="control-label col-sm-3" for="">หมายเหตุ</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control"  rows="2" disabled>{{ $row_bill_details -> reject_description }}</textarea>
                                    </div>
                                    </div>
                                </div>
                                </div>
                                {{-- <div class="row">
                                <div class="col-md-12" align="center">
                                    <button id="{{ $row_bill_details -> id }}" class="submit btn btn-warning" style="text-decoration: none; margin-right: 20px; margin-top: 12px;" disabled>ส่งไปรายการที่ต้องแก้ไข</button>
                                </div>
                                </div> --}}
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="modal-footer">
                    {!! Form::model($row_bill_details, ['method' => 'PATCH', 'route' => ['quality-control-reject.update', $row_bill_details -> id]]) !!}
                        <div class="col-md-12 form-margin" align="right">
                            <div class="form-group">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-success" style="margin-top: 12px;"><i class="fas fa-clipboard-check"></i>&nbsp;&nbsp;ยืนยันการแก้ไข</button>
                                <button class="btn btn-default reset-interval" data-dismiss="modal" aria-hidden="true" style="margin-top: 12px;">ปิด</button>
                            </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div> --}}
              </div>
            </div>
          </div>
        @endforeach
        @endif
    </div>
  </div>
@endsection
@section('script')
  <script>
    // var myVar = setInterval(function(){
    //     location = ''
    // },6000)
    // $( ".reject" ).click(function() {
    //     clearInterval(myVar);
    // });
    // $( ".reset-interval" ).click(function() {
    //     setInterval(function(){
    //         location = ''
    //     },6000)
    // });
  </script>
@endsection
