@extends('layouts.master')

@section('title', 'อัพเดทสถานะการส่งสินค้า')

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
    .new-bg {
      background-color: #E8E8E8;
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
    .dlk-radio input[type="radio"],
    .dlk-radio input[type="checkbox"]
    {
      /* margin-left:-99999px; */
      display:none;
    }
    .dlk-radio input[type="radio"] + .fa ,
    .dlk-radio input[type="checkbox"] + .fa {
        opacity:0.15
    }
    .dlk-radio input[type="radio"]:checked + .fa,
    .dlk-radio input[type="checkbox"]:checked + .fa{
        opacity:1
    }
  </style>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12 col-sm-12">
      <div class="row">
        <div class="col-md-12 col-sm-12 form__responsive">
          <div class="row">
            <div class="col-md-12 col-sm-12">
              <label style="font-size: 19px;">อัพเดทสถานะการส่งสินค้า</label>
            </div>
          </div>
          <hr>
        </div>
      </div>
      <table id="example" class="display">
        <thead>
            <tr>
                <th width="13%">ลำดับส่ง</th>
                <th width="15%">เวลาเปิดบิล</th>
                <th width="5%">สาย</th>
                <th>ชื่อลูกค้า</th>
                <th>เลขที่บิล</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
          {{-- <div id="actors"> --}}
            @foreach($bill_details as $row_bill_details)
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
                            <form action="{{ url('update-bill-send-item') }}" method="GET">
                              <input name="bill_id" class="form-control" type="hidden" value="{{ $row_bill_details -> id }}">
                              <div class="col-md-12 form-margin" align="right">
                                <div class="form-group">
                                  <div class="col-sm-12">
                                    <button type="submit" id="submit_modal{{ $row_bill_details -> id }}" class="btn btn-success" style="margin-top: 12px;"><i class="fas fa-clipboard-check"></i>&nbsp;&nbsp;ยืนยันการส่งสินค้า</button>
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
                                          <textarea class="form-control reject_description" name="reject_description{{ $row_bill_details -> id }}" data-testval="{{ $row_bill_details -> id }}" rows="2"></textarea>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-12" align="center">
                                      <button id="{{ $row_bill_details -> id }}" class="submit btn btn-warning" style="text-decoration: none; margin-right: 20px; margin-top: 12px;" disabled>ส่งไปรายการที่ต้องแก้ไข</button>
                                    </div>
                                  </div>
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
          {{-- </div> --}}
        </tbody>
      </table>
    </div>
  </div>
@endsection

@section('script')
  <script>
    // disabled check submit button
    $(document).on('keyup', '.reject_description', function() {
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

    // submit reject
    $(".submit").click(function(e) {
      e.preventDefault();
      let bill_id = this.id;
      let reject_description = $('textarea[name=reject_description'+bill_id+']').val();
      $.ajax({
        url: '/ajax/request-reject?bill_id='+bill_id+'&reject_description='+reject_description,
        type: 'POST',
        dataType: 'JSON',
        success: function(response) {
          location.reload();
        },
        error: function(response) {
          console.log('ไม่สามารถติดต่อ server ได้');
        }
      });
    });
  </script>
@endsection
