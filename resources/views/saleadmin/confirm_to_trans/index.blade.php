@extends('layouts.master')

@section('title', 'คอนเฟริมแผนกขนส่ง')

@section('stylesheet')
  <style>
    .wrapper_modal {
      padding: 10px;
    }
    .new-bg {
      background-color: #E8E8E8;
      border: 1px solid #B8B8B8;
    }
    .form-margin {
      margin-top: 5px;
      margin-bottom: 5px;
    }
    .control-label {
      margin-top: 5px;
    }
    hr {
      padding: 0;
      margin-top: 18px;
      margin-bottom: 18px;
    }
    hr {
      margin-top: 12px;
      margin-bottom: 12px;
    }
  </style>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12 col-sm-12">
      <div class="row">
        <div class="col-md-12 col-sm-12 form__responsive">
          <div class="row">
            <div class="col-md-7 col-sm-7">
              <label style="font-size: 19px;">คอนเฟริมแผนกขนส่ง</label>
            </div>
            <div class="col-md-5 col-sm-5" align="right">
              <button id="status_btn" class="btn new-bg" disabled><i class="fas fa-paper-plane"></i>&nbsp;&nbsp;คอนเฟริมแผนกขนส่ง</button>
            </div>
          </div>
          <hr>
        </div>
      </div>
      <table id="example" class="display">
        <thead>
            <tr>
                <th width="12%">ลำดับส่ง</th>
                <th width="17%">เวลาเปิดบิล</th>
                <th width="5%">สาย</th>
                <th>ชื่อลูกค้า</th>
                <th>เลขที่บิล</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
          @foreach ($final_bills as $final_bill)
            <tr style="background-color: #F0F0F0;">
              <td colspan="7" style="font-weight: normal;">
                <input type="checkbox" class="checkbox_bill" value="{{ $final_bill -> id }}" />
                &nbsp;&nbsp;ใบวางบิลเลขที่ {{ $final_bill -> final_bill_code }}
              </td>
            </tr>
            @foreach ($final_bill -> get_bill_details as $row_bill_details)
              <tr>
                <td>{{ $row_bill_details -> get_customer_route -> cus_route_order }}</td>
                <td>{{ $row_bill_details -> time_to_start -> format('H:i:s') . " น." }}</td>
                <td>{{ $row_bill_details -> get_customer_route -> get_route -> route_code }}</td>
                <td>{{ $row_bill_details -> get_customer -> cus_name }}</td>
                <td>{{ $row_bill_details -> bill_code }}</td>
                <td align="center"><a href="#ModalCheckingDone" data-toggle="modal" data-target="#ModalCheckingDone{{ $row_bill_details -> id }}"><i class="fas fa-search" style="font-size: 17px;"></i></a></td>
              </tr>
              <!-- Modal View -->
              <div class="modal fade" id="ModalCheckingDone{{ $row_bill_details -> id }}" role="dialog">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h5 class="modal-title" style="font-weight: bold;">รายละเอียดข้อมูล&nbsp;&nbsp;:&nbsp;&nbsp;{{ $row_bill_details -> bill_code }}</h5>
                    </div>
                    <div class="modal-body">
                      <div class="row">
                        <div class="col-md-12">
                          <span class="pull-left">วันที่เปิดบิล&nbsp;{{ shortFormatDateThai(date('Y-m-d', strtotime($row_bill_details -> time_to_start))) }}</span>
                          <span class="pull-right">เวลาที่เปิดบิล&nbsp;{{ $row_bill_details -> time_to_start -> format('H:i:s') . " น." }}</span>
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
                                <input type="text" class="form-control" id="" value="{{ $row_bill_details -> get_customer_route -> get_route -> route_code }}" readonly>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6 form-margin">
                            <div class="form-group">
                              <label class="control-label col-sm-3" for="">เลขที่บิล :</label>
                              <div class="col-sm-9">
                                <input type="text" class="form-control" id="" value="{{ $row_bill_details -> bill_code }}" readonly>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6 form-margin">
                            <div class="form-group">
                              <label class="control-label col-sm-3" for="">รหัสลูกค้า :</label>
                              <div class="col-sm-9">
                                <input type="text" class="form-control" id="" value="{{ $row_bill_details -> get_customer -> cus_code }}" readonly>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6 form-margin">
                            <div class="form-group">
                              <label class="control-label col-sm-3" for="">ชื่อลูกค้า :</label>
                              <div class="col-sm-9">
                                <input type="text" class="form-control" id="" value="{{ $row_bill_details -> get_customer -> cus_name }}" readonly>
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
                                <input type="text" class="form-control" value="{{ $row_bill_details -> get_packer -> emp_code  }}" readonly>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6 form-margin">
                            <div class="form-group">
                              <label class="control-label col-sm-3" for="">ชื่อผู้แพ็ค :</label>
                              <div class="col-sm-9">
                                <input type="text" class="form-control" value="{{ $row_bill_details -> get_packer -> emp_firstname . " " . $row_bill_details -> get_packer -> emp_lastname }}" readonly>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6 form-margin">
                            <div class="form-group">
                              <label class="control-label col-sm-3" for="">จำนวน :</label>
                              <div class="col-sm-9">
                                <div class="input-group">
                                  <input type="text" class="form-control" id="" value="{{ $row_bill_details -> total }}" aria-describedby="basic-addon2" readonly>
                                  <span class="input-group-addon" id="basic-addon2">กล่อง</span>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6 form-margin">
                            <div class="form-group">
                              <label class="control-label col-sm-3" for="">พาเลทที่ :</label>
                              <div class="col-sm-9">
                                <input type="text" class="form-control" id="" value="{{ $row_bill_details -> total_parlate }}" readonly>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6 form-margin">
                            <div class="form-group">
                              <label class="control-label col-sm-3" for="">เวลาตรวจ :</label>
                              <div class="col-sm-9">
                                <input type="text" class="form-control" id="" value="{{ FullFormatDateThai(date('Y-m-d H:i:s', strtotime($row_bill_details -> time_to_qc))) }}" readonly>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6 form-margin">
                            <div class="form-group">
                              <label class="control-label col-sm-3" for="">เวลาแพ็ค :</label>
                              <div class="col-sm-9">
                                <input type="text" class="form-control" id="" value="{{ FullFormatDateThai(date('Y-m-d H:i:s', strtotime($row_bill_details -> end_to_pack))) }}" readonly>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6 form-margin">
                            <div class="form-group">
                              <label class="control-label col-sm-3" for="">รหัสผู้ตรวจ :</label>
                              <div class="col-sm-9">
                                <input type="text" class="form-control" id="" value="{{ $row_bill_details -> get_qc -> emp_code }}" readonly>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6 form-margin">
                            <div class="form-group">
                              <label class="control-label col-sm-3" for="">ชื่อผู้ตรวจ :</label>
                              <div class="col-sm-9">
                                <input type="text" class="form-control" id="" value="{{ $row_bill_details -> get_qc -> emp_firstname ." ". $row_bill_details -> get_qc -> emp_lastname }}" readonly>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-12 form-margin" align="right">
                            <div class="form-group">
                              <div class="col-sm-12">
                                <a class="btn btn-default" class="close" data-dismiss="modal" style="margin-top: 12px;">ปิด</a>
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
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection

@section('script')
  <script>
    // checkbox check and show btn
    var final_bill_id_array = [];
    $('.checkbox_bill').change(function() {
      final_bill_id_array = [];
      var cboxes = document.getElementsByClassName('checkbox_bill');
      for(let i = 0; i < cboxes.length; i++) {
        if(cboxes[i].checked) {
          final_bill_id_array.push(cboxes[i].value);
        }
      }
      validateStatusBtn();
    });
    function validateStatusBtn() {
      let count = final_bill_id_array.length;
      if(count > 0) {
        $('#status_btn').removeAttr('disabled');
        $('#status_btn').addClass('btn-default');
      } else {
        $('#status_btn').attr('disabled', '');
        $('#status_btn').removeClass('btn-default')
      }
    }

    // update final bill status
    $(document).on('click', '#status_btn', function() {
      $.ajax({
        url: '/ajax/update-final-bill-data',
        type: 'POST',
        dataType: 'JSON',
        data: {final_bill_ids: final_bill_id_array},
        success: function(response) {
          if(response === 'success') {
            window.location.reload();
          }
        },
        error: function(response) {
          console.log('ไม่สามารถติดต่อ server ได้');
        }
      });
    });
  </script>
@endsection
