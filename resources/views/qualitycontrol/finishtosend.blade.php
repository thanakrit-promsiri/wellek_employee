@extends('layouts.master')

@section('title', 'รายการที่พร้อมส่ง')

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
          <label style="font-size: 19px;">รายการที่พร้อมส่ง<span>&nbsp;&nbsp;{{ $bill_details_finish_to_pack_count }}&nbsp;&nbsp;รายการ</span></label>
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
                <th width="13%">เวลาเปิดบิล</th>
                {{-- <th>สาย</th> --}}
                <th width="10%">รหัสลูกค้า</th>
                <th>ชื่อลูกค้า</th>
                <th>เลขที่บิล</th>
                <th width="16%">เวลาตรวจ</th>
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
                    <td>{{ $row_bill_details_qc -> time_to_qc -> format('H:i:s') . " น." }}</td>
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
                                <label class="control-label col-sm-3" for="">เริ่มแพ็ค :</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" id="" value="{{ $row_bill_details_qc -> start_to_pack -> format('H:i:s') . " น." }}" readonly>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6 form-margin">
                              <div class="form-group">
                                <label class="control-label col-sm-3" for="">แพ็คเสร็จ :</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" id="" value="{{ $row_bill_details_qc -> end_to_pack -> format('H:i:s') . " น." }}" readonly>
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
                            <div class="col-md-12">
                              <hr>
                            </div>
                            <div class="col-md-6">
                              <div class="description-wrapper">
                                <div class="description-box">
                                  <div class="row">
                                    <div class="col-md-12" align="center">
                                      <span style="color: red; font-weight: normal; font-size: 13px;">เมื่อทำการเพิ่ม/แก้ไขหมายเหตุ อย่าลืมกด "บันทึกหมายเหตุ" ด้วยทุกครั้งก่อนพิมพ์สติ๊กเกอร์</span>
                                    </div>
                                  </div>
                                  <div class="row" style="margin-top: 7px;">
                                    <div class="col-md-12 form-margin">
                                      <div class="form-group">
                                        <label class="control-label col-sm-3" for="">หมายเหตุ</label>
                                        <div class="col-sm-9">
                                          <textarea class="form-control note" name="note{{ $row_bill_details_qc -> id }}" data-testval="{{ $row_bill_details_qc -> id }}" rows="2">{{ $row_bill_details_qc -> bill_description }}</textarea>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-12" align="center">
                                      <button id="{{ $row_bill_details_qc -> id }}" class="submit btn btn-success" style="text-decoration: none; margin-right: 20px; margin-top: 12px;" disabled>บันทึกหมายเหตุ</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6 form-margin" align="right">
                              <div class="form-group">
                                <div class="col-sm-12" style="margin-top: 150px;">
                                  <a href="{{ url('qc-label-get-one-page?bill_id='.$row_bill_details_qc -> id) }}" target="_blank" style="text-decoration: none;"><i class="fas fa-print" style="font-size: 17px;"></i>&nbsp;พิมพ์สติ๊กเกอร์</a>
                                </div>
                              </div>
                            </div>
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
    // disabled check submit button
    $(document).on('keyup', '.note', function() {
      let id = $(this).data('testval');
      let note = $(this).val();
      validateSubmit(id, note);
    });
    function validateSubmit(id, note) {
      if(note != '' && note != null) {
        $('#'+id).removeAttr('disabled');
      } else {
        $('#'+id).attr('disabled', '');
      }
    }

    // save bill_description
    $(".submit").click(function(e) {
      e.preventDefault();
      var bill_id = this.id;
      var bill_description = $('textarea[name=note'+bill_id+']').val();
      $.ajax({
        url: '/ajax/request-bill-detail-edit-bill_description?bill_id='+bill_id+'&bill_description=' + bill_description,
        type: 'POST',
        dataType: 'JSON',
        success: function(response) {
          console.log(response);
          $('#'+bill_id).attr('disabled', '');
        },
        error: function(response) {
          console.log('ไม่สามารถติดต่อ server ได้');
        }
      });
    });
  </script>
@endsection
