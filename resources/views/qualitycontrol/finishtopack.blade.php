@extends('layouts.master')

@section('title', 'รายการที่กำลังแพ็ค')

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
        <div class="col-md-12 col-sm-12">
          <label style="font-size: 19px;">รายการที่กำลังแพ็ค<span>&nbsp;&nbsp;{{ $bill_details_finish_to_pack_count }}&nbsp;&nbsp;รายการ</span></label>
        </div>
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
                {{-- <th>สาย</th> --}}
                <th width="15%">รหัสลูกค้า</th>
                <th>ชื่อลูกค้า</th>
                <th>เลขที่บิล</th>
                <th width="16%">เวลาเริ่มแพ็ค</th>
                {{-- <th>รหัส Packer</th> --}}
                {{-- <th>จำนวน</th>
                <th>พาเลท</th>
                <th>เวลา Pack</th> --}}
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            @php($no = 1)
            @foreach($bill_details_qc as $row_bill_details_qc)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $row_bill_details_qc -> time_to_start -> format('H:i:s') . " น." }}</td>
                    {{-- <td>{{ $row_bill_details_qc -> get_customer_route -> get_route -> route_code }}</td> --}}
                    <td>{{ $row_bill_details_qc -> get_customer -> cus_code }}</td>
                    <td>{{ $row_bill_details_qc -> get_customer -> cus_name }}</td>
                    <td>{{ $row_bill_details_qc -> bill_code }}</td>
                    <td>{{ $row_bill_details_qc -> start_to_pack -> format('H:i:s') . " น." }}</td>
                    {{-- <td>{{ $row_bill_details_qc -> get_packer -> emp_code }}</td> --}}
                    {{-- <td>{{ $row_bill_details_qc -> total }}</td>
                    <td>{{ $row_bill_details_qc -> total_parlate }}</td>
                    <td>{{ $row_bill_details_qc -> time_to_pack -> format('H:i:s') . " น." }}</td> --}}
                    <td align="center"><a href="#ModalCheckingDone" data-toggle="modal" data-target="#ModalCheckingDone{{$row_bill_details_qc -> id}}"><i class="fas fa-search" style="font-size: 17px;"></i></a></td>
                </tr>

                <!-- Modal -->
                <div class="modal fade" id="ModalCheckingDone{{ $row_bill_details_qc -> id }}" role="dialog">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5 class="modal-title" style="font-weight: bold;">รายละเอียดข้อมูล&nbsp;&nbsp;:&nbsp;&nbsp;{{ $row_bill_details_qc -> bill_code }}</h5>
                      </div>
                      <div class="modal-body">
                        <div class="row">
                          <div class="col-md-12">
                            <span class="pull-left">วันที่เปิดบิล&nbsp;{{ shortFormatDateThai(date('Y-m-d', strtotime($row_bill_details_qc -> time_to_start))) }}</span>
                            <span class="pull-right">เวลาที่เปิดบิล&nbsp;{{ $row_bill_details_qc -> time_to_start -> format('H:i:s') . " น." }}</span>
                          </div>
                        </div>
                        <div class="wrapper_modal">
                          <div class="row">
                            <div class="col-md-12">
                              <hr>
                            </div>
                            <div class="col-md-6 form-margin">
                              <div class="form-group">
                                <label class="control-label col-sm-3" for="">สาย :</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" id="" value="{{ $row_bill_details_qc -> get_customer_route -> get_route -> route_code }}" readonly>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6 form-margin">
                              <div class="form-group">
                                <label class="control-label col-sm-3" for="">เลขที่บิล :</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" id="" value="{{ $row_bill_details_qc -> bill_code }}" readonly>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6 form-margin">
                              <div class="form-group">
                                <label class="control-label col-sm-3" for="">รหัสลูกค้า :</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" id="" value="{{ $row_bill_details_qc -> get_customer -> cus_code }}" readonly>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6 form-margin">
                              <div class="form-group">
                                <label class="control-label col-sm-3" for="">ชื่อลูกค้า :</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" id="" value="{{ $row_bill_details_qc -> get_customer -> cus_name }}" readonly>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-12">
                              <hr>
                            </div>
                            <div class="col-md-6 form-margin">
                              <div class="form-group">
                                <label class="control-label col-sm-3" for="">รหัสผู้แพ็ค :</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" value="{{ $row_bill_details_qc -> get_packer -> emp_code  }}" readonly>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6 form-margin">
                              <div class="form-group">
                                <label class="control-label col-sm-3" for="">ชื่อผู้แพ็ค :</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" value="{{ $row_bill_details_qc -> get_packer -> emp_firstname . " " . $row_bill_details_qc -> get_packer -> emp_lastname }}" readonly>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6 form-margin">
                              <div class="form-group">
                                <label class="control-label col-sm-3" for="">จำนวน :</label>
                                <div class="col-sm-9">
                                  <div class="input-group">
                                    <input type="text" class="form-control" id="" value="{{ $row_bill_details_qc -> total }}" aria-describedby="basic-addon2" readonly>
                                    <span class="input-group-addon" id="basic-addon2">กล่อง</span>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6 form-margin">
                              <div class="form-group">
                                <label class="control-label col-sm-3" for="">พาเลทที่ :</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" id="" value="{{ $row_bill_details_qc -> total_parlate }}" readonly>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6 form-margin">
                              <div class="form-group">
                                <label class="control-label col-sm-3" for="">เวลาตรวจ :</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" id="" value="{{ FullFormatDateThai(date('Y-m-d H:i:s', strtotime($row_bill_details_qc -> time_to_qc))) }}" readonly>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6 form-margin">
                              <div class="form-group">
                                <label class="control-label col-sm-3" for="">เวลาแพ็ค :</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" id="" value="{{ FullFormatDateThai(date('Y-m-d H:i:s', strtotime($row_bill_details_qc -> start_to_pack))) }}" readonly>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6 form-margin">
                              <div class="form-group">
                                <label class="control-label col-sm-3" for="">รหัสผู้ตรวจ :</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" id="" value="{{ $row_bill_details_qc -> get_qc -> emp_code }}" readonly>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6 form-margin">
                              <div class="form-group">
                                <label class="control-label col-sm-3" for="">ชื่อผู้ตรวจ :</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" id="" value="{{ $row_bill_details_qc -> get_qc -> emp_firstname ." ". $row_bill_details_qc -> get_qc -> emp_lastname }}" readonly>
                                </div>
                              </div>
                            </div>
                            {!! Form::model($row_bill_details_qc, ['method' => 'PATCH', 'route' => ['quality-control-end-to-pack.update', $row_bill_details_qc -> id]]) !!}
                              <div class="col-md-6 form-margin">
                                  <div class="form-group">
                                      <div class="col-sm-9">
                                          <input type="hidden" class="form-control" name="bill_id" value="{{$row_bill_details_qc -> id}}" readonly>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-12 form-margin" align="right">
                                <div class="form-group">
                                  <div class="col-sm-12" style="padding-top: 12px;">
                                        <button type="submit" class="btn btn-success" style="margin-top: 12px;"><i class="fas fa-box"></i>&nbsp;&nbsp;ยืนยันการแพ็ค</button>
                                  </div>
                                </div>
                              </div>
                            {!! Form::close() !!}
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Modal -->
            @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
@section('script')
  <script>
    //
  </script>
@endsection
