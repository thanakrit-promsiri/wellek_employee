@extends('layouts.master')

@section('title', 'ออกเลขที่ใบวางบิล')

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
              <label style="font-size: 19px;">ออกเลขที่ใบวางบิล</label>
            </div>
            <div class="col-md-5 col-sm-5" align="right">
              <button id="status_btn" class="btn new-bg" data-toggle="modal" data-target="#insertFinalBill" disabled><i class="far fa-edit"></i>&nbsp;&nbsp;กรอกเลขที่ใบวางบิล</button>
            </div>
          </div>
          <hr>
        </div>
      </div>
      <table id="example" class="display">
        <thead>
            <tr>
                <th width="7%">&nbsp;</th>
                <th width="12%">ลำดับส่ง</th>
                <th width="17%">เวลาเปิดบิล</th>
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
                    <td><input type="checkbox" class="checkbox_bill" name="check_id" value="{{ $row_bill_details -> id }}"></td>
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
      <!-- Modal Insert -->
      <div class="modal fade" id="insertFinalBill" role="dialog">
          <div class="modal-dialog">
              <!-- Modal content-->
              <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h5 class="modal-title" style="font-weight: bold;">กรอกข้อมูลรายละเอียด</h5>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-md-12 form-margin">
                        <div class="form-group">
                          <label class="control-label col-sm-3" for="final_bill_code">เลขที่ใบวางบิล</label>
                          <div class="col-sm-9">
                            <div class="input-group">
                              <input type="text" class="form-control only_eng_and_num" name="final_bill_code" id="final_bill_code" aria-describedby="basic-addon1" onkeyup="this.value=this.value.toUpperCase();">
                              <span class="input-group-addon" id="basic-addon1"><i class="fas fa-check-circle" style="font-size: 15px; color: #B4B4B4;"></i></span>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12 form-margin">
                        <div class="form-group">
                          <label class="control-label col-sm-3" for="final_bill_cost">ราคา</label>
                          <div class="col-sm-9">
                            <div class="input-group" style="margin-bottom: 5px;">
                              <input type="text" class="form-control number_format" name="final_bill_cost" id="final_bill_cost" aria-describedby="basic-addon2" onkeypress="return isNumberOrDot(event);">
                              <span class="input-group-addon" id="basic-addon2">บาท</span>
                            </div>
                            <span id="show_total_cost"></span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer" style="margin-top: 5px">
                    <button type="submit" id="save_status_btn" class="btn btn-success" disabled><i class="fas fa-check-circle"></i>&nbsp;&nbsp;บันทึก</button>
                    <a class="btn btn-default" class="close" data-dismiss="modal"><i class="fas fa-times"></i>&nbsp;&nbsp;ปิด</a>
                  </div>
              </div>
          </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script>
    // in modal
    var save_status_btn = 0;
    $('#final_bill_code, #final_bill_cost').keyup(function() {
      checkStatus();
    });
    function checkStatus() {
      let code = $('#final_bill_code').val();
      let cost = $('#final_bill_cost').val();
      if(code.length >= 10 && cost != '' && cost != null) {
        $.ajax({
          url: '/ajax/validate-final-bill-code',
          type: 'GET',
          dataType: 'JSON',
          data: {code: code},
          success: function(response) {
            if(response === 'success') {
              $('#basic-addon1').html('<i class="fas fa-check-circle" style="font-size: 15px; color: #16AE04;"></i>');
              save_status_btn = 1;
              validateStatus();
            } else if(response === 'fail') {
              $('#basic-addon1').html('<i class="fas fa-ban" style="font-size: 15px; color: #CF0000;"></i>');
              save_status_btn = 0;
              validateStatus();
            }
          },
          error: function(response) {
            console.log('ไม่สามารถติดต่อ server ได้');
          }
        });
      } else {
        $('#basic-addon1').html('<i class="fas fa-check-circle" style="font-size: 15px; color: #B4B4B4;"></i>');
        save_status_btn = 0;
        validateStatus();
      }
    }
    function validateStatus() {
      if(save_status_btn > 0) {
        $('#save_status_btn').removeAttr('disabled');
      } else {
        $('#save_status_btn').attr('disabled', '');
      }
    }

    // โชว์หน่วยเงินตามฟอแมท
    $('.number_format').keyup(function() {
      $('#show_total_cost').html('');
      let value = $(this).val();
      if(value != '' && value != null) {
        let final = get_format_num(value);
        $('#show_total_cost').html(final + ' บาท');
      } else {
        $('#show_total_cost').html('');
      }
    });
    function get_format_num(num) {
      let parts = num.toString().split(".");
      let final = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",") + (parts[1] ? "." + parts[1] : "");
      return final;
    }

    // checkbox check and show btn to toggle modal
    var bill_id_array = [];
    $('.checkbox_bill').change(function() {
      bill_id_array = [];
      var cboxes = document.getElementsByClassName('checkbox_bill');
      for(let i = 0; i < cboxes.length; i++) {
        if(cboxes[i].checked) {
          bill_id_array.push(cboxes[i].value);
        }
      }
      validateStatusBtn();
    });
    function validateStatusBtn() {
      let count = bill_id_array.length;
      if(count > 0) {
        $('#status_btn').removeAttr('disabled');
        $('#status_btn').addClass('btn-default');
      } else {
        $('#status_btn').attr('disabled', '');
        $('#status_btn').removeClass('btn-default')
      }
    }

    $(document).on('click', '#save_status_btn', function(event) {
      let data_bill_id = bill_id_array;
      let data_code = $('#final_bill_code').val();
      let data_cost = $('#final_bill_cost').val();
      $.ajax({
        url: '/ajax/save-final-bill-data',
        type: 'POST',
        dataType: 'JSON',
        data: {data_bill_id: data_bill_id, data_code: data_code, data_cost: data_cost},
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
