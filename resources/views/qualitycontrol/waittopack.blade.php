@extends('layouts.master')

@section('title', 'รายการที่รอแพ็ค')

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
  </style>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12 col-sm-12 form__responsive">
      <div class="row">
        <div class="col-md-12 col-sm-12">
          <label style="font-size: 19px;">รายการที่รอแพ็ค<span>&nbsp;&nbsp;{{ $bill_details_wait_to_pack_count }}&nbsp;&nbsp;รายการ</span></label>
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
                <th width="9%">&nbsp;</th>
                <th width="13%">เวลาเปิดบิล</th>
                <th width="5%">สาย</th>
                <th width="15%">รหัสลูกค้า</th>
                <th>ชื่อลูกค้า</th>
                <th>เลขที่บิล</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            @php($no = 1)
            @foreach($bill_details as $row_bill_details)
                <tr>
                    <td>{{ $no++ }}</td>
                    @if($row_bill_details -> status == 3)
                      <td></td>
                    @elseif($row_bill_details -> status == 4)
                      <td>PK&nbsp;<i class='far fa-clock' style="color: #6F6F6F;"></i></td>
                    @endif
                    <td>{{ FullFormatDateThai(date('Y-m-d H:i:s', strtotime($row_bill_details -> time_to_start))) }}</td>
                    <td>{{ $row_bill_details -> get_customer_route -> get_route -> route_code }}</td>
                    <td>{{ $row_bill_details -> get_customer -> cus_code }}</td>
                    <td>{{ $row_bill_details -> get_customer -> cus_name }}</td>
                    <td>{{ $row_bill_details -> bill_code }}</td>
                    <td><a href="#" data-toggle="modal" data-target="#ModalChecking{{ $row_bill_details -> id }}"><i class="fas fa-search" style="font-size: 17px;"></i></a></td>
                </tr>
                <!-- Modal -->
                <div class="modal fade" id="ModalChecking{{ $row_bill_details -> id }}" role="dialog">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5 class="modal-title" style="font-weight: bold;">รายละเอียดบิล&nbsp;&nbsp;:&nbsp;&nbsp;{{ $row_bill_details -> bill_code }}</h5>
                      </div>
                      <div class="modal-body">
                        <div class="wrapper_modal">
                          <div class="row">
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
                            {{-- <div class="col-md-6 form-margin">
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
                            </div> --}}
                            @if($row_bill_details -> status == 3)
                              {!! Form::model($row_bill_details, ['method' => 'PATCH', 'route' => ['quality-control-wait-to-pack.update', $row_bill_details -> id]]) !!}
                                <div class="col-md-6 form-margin">
                                  <div class="form-group">
                                    <label class="control-label col-sm-3" for="">รหัสผู้แพ็ค :</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control packer_id" id="{{ $row_bill_details -> id }}" name="packer_id" onkeyup="this.value=this.value.toUpperCase();" required>
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                <div class="col-md-6 form-margin">
                                  <div class="form-group">
                                    <label class="control-label col-sm-3" for="">ชื่อผู้แพ็ค :</label>
                                    <div class="col-sm-9" style="padding-top: 8px;">
                                      <div id="alert_packer_id{{ $row_bill_details -> id }}">กรุณากรอกรหัสผู้แพ็ค...</div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                                <div class="col-md-12 form-margin" align="right">
                                  <div class="form-group">
                                    <div class="col-sm-12">
                                      <button type="submit" id="submit_modal_packer{{ $row_bill_details -> id }}" class="btn btn-success" style="margin-top: 12px;" disabled><i class="fas fa-box"></i>&nbsp;&nbsp;ยืนยันผู้แพ็ค</button>
                                    </div>
                                  </div>
                                </div>
                              {!! Form::close() !!}
                            @elseif($row_bill_details -> status == 4)
                              {!! Form::model($row_bill_details, ['method' => 'PATCH', 'route' => ['quality-control-wait-to-pack.update', $row_bill_details -> id]]) !!}
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
                                    <label class="control-label col-sm-3" for="">เริ่มแพ็ค :</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" value="{{ $row_bill_details -> start_to_pack -> format('H:i:s') . " น." }}" readonly>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-6 form-margin">
                                  <div class="form-group">
                                    <label class="control-label col-sm-3" for=""></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" style="visibility: hidden;">
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-12">
                                  <hr>
                                </div>
                                <div class="col-md-6 form-margin">
                                  <div class="form-group">
                                    <label class="control-label col-sm-3" for="">จำนวน :</label>
                                    <div class="col-sm-9">
                                      <div class="input-group">
                                        <input type="text" class="form-control total" data-id="{{ $row_bill_details -> id }}" id="total{{ $row_bill_details -> id }}" name="total" onkeypress="return isNumber(event)" required>
                                        <span class="input-group-addon">กล่อง</span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-6 form-margin">
                                  <div class="form-group">
                                    <label class="control-label col-sm-3" for="">พาเลทที่ :</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control total_parlate" data-id="{{ $row_bill_details -> id }}" id="total_parlate{{ $row_bill_details -> id }}" name="total_parlate" onkeypress="return isNumber(event)" required>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-12 form-margin" align="right">
                                  <div class="form-group">
                                    <div class="col-sm-12">
                                      <button type="submit" id="submit_modal{{ $row_bill_details -> id }}" class="btn btn-success" style="margin-top: 12px;" disabled><i class="fas fa-box"></i>&nbsp;&nbsp;ยืนยันการแพ็ค</button>
                                    </div>
                                  </div>
                                </div>
                              {!! Form::close() !!}
                            @endif
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
    $('.packer_id').keyup(function(event) {
        let bill_id = this.id;
        let packer_id = $(this).val();
        $('#alert_packer_id'+bill_id).hide();
        if(packer_id != '' && packer_id != null) {
          $.ajax({
            url: '/ajax/validate-packer-id',
            type: 'GET',
            dataType: 'JSON',
            data: {packer_id: packer_id},
            success: function(response) {
              if(response === 'fail') {
                $('#submit_modal_packer'+bill_id).attr('disabled', '');
                $('#alert_packer_id'+bill_id).html('ไม่มีข้อมูลพนักงานเช็คสินค้า');
                $('#alert_packer_id'+bill_id).show();
              } else {
                $('#submit_modal_packer'+bill_id).removeAttr('disabled');
                $('#alert_packer_id'+bill_id).html('คุณ' + response.emp_firstname + ' ' + response.emp_lastname);
                $('#alert_packer_id'+bill_id).show();
              }
            },
            error: function(response) {
              console.log('ไม่สามารถติดต่อ server ได้');
            }
          });
        } else {
          $('#submit_modal_packer'+bill_id).attr('disabled', '');
          $('#alert_packer_id'+bill_id).html('กรุณากรอกรหัสผู้แพ็ค...');
          $('#alert_packer_id'+bill_id).show();
        }
    });

    $('.total, .total_parlate').keyup(function(event) {
      let id = $(this).data("id");
      let total_val = $('#total'+id).val();
      let total_parlate_val = $('#total_parlate'+id).val();
      if(total_val !== '' && total_val !== null && total_parlate_val !== '' && total_parlate_val !== null) {
        if(total_val > 0 && total_parlate_val > 0) {
          $('#submit_modal'+id).removeAttr('disabled');
        } else {
          $('#submit_modal'+id).attr('disabled', '');
        }
      } else {
        $('#submit_modal'+id).attr('disabled', '');
      }
    });
  </script>
@endsection
