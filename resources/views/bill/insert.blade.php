@extends('layouts.master')

@section('title', 'ออกบิล')

@section('stylesheet')
  <style>
    .wrapper {
      margin: 15px;
    }
    .box-detail {
      position: relative;
      border: 1px solid black;
      border-radius: 5px;
      padding: 10px;
    }
    .request_edit_input {
      margin-top: 3px;
    }
    .request_edit_input_alert {
      border: 1px solid #FF675B;
      background-color: #FFE4E2;
    }
    label {
      margin: 2px;
    }
  </style>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12 col-sm-12">
      <div class="wrapper">
        <div class="box-detail">
          <div class="row">
            <div class="col-md-12">
              <label>สาย</label><br>
              <span>-&nbsp;{{ $customer_route -> get_route -> route_code . " - " . $customer_route -> get_route -> route_description }}</span>
            </div>
          </div>
          <div class="row" style="margin-top: 5px;">
            <div class="col-md-12">
              <label>ลูกค้า</label><br>
              <span>-&nbsp;{{ $customer_route -> get_customer -> cus_code . " - " . $customer_route -> get_customer -> cus_name }}</span>
            </div>
          </div>
        </div>
      </div>
      <div class="wrapper">
        <form action="{{ route('open-bill.store') }}" method="POST">
        {{ csrf_field() }}
          <input id="cus_id" name="cus_id" value="{{ $customer_route -> get_customer -> id }}" style="display: none;" />
          <!-- Modal description new -->
          @if($bill_details -> isEmpty())
            <div id="modalDescriptionNew1" class="modal fade" role="dialog">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h5 class="modal-title" style="font-weight: bold;">กรอกหมายเหตุ</h5>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-md-12">
                        <input type="text" class="form-control description_bill" name="description_bill[]" value="-" />
                      </div>
                    </div>
                    <div class="row" style="margin-top: 10px;">
                      <div class="col-md-12" align="right">
                        <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @endif
          <!-- Modal description new -->
          <div id="modal_description_new"></div>
          <table class="custom_table">
            <tr>
              <th width="8%">&nbsp;</th>
              <th>เลขที่บิล</th>
              <th width="18%">เวลาส่ง</th>
              <th width="18%">เวลาออกบิล</th>
              <th width="12%">หมายเหตุ</th>
            </tr>
            @php($no = 1)
            @forelse($bill_details as $row)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $row -> bill_code }}</td>
                <td>{{ shortFormatDateThai(date('Y-m-d', strtotime($row -> time_to_send))) }}</td>
                <td>{{ $row -> time_to_start -> format('H:i:s') . " น." }}</td>
                <td>
                  @if(!empty($row -> bill_description))
                    <a data-toggle="modal" data-target="#modalDescription{{ $row -> id }}" style="text-decoration: none; cursor: pointer;"><i class="fas fa-clipboard-list"></i></a>
                  @else
                    -
                  @endif
                </td>
              </tr>
              <!-- Modal description sql -->
              <div id="modalDescription{{ $row -> id }}" class="modal fade" role="dialog">
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h5 class="modal-title" style="font-weight: bold;">กรอกหมายเหตุ</h5>
                    </div>
                    <div class="modal-body">
                      <div class="row">
                        <div class="col-md-12">
                          <input type="text" class="form-control" value="{{ $row -> bill_description }}" readonly />
                        </div>
                      </div>
                      <div class="row" style="margin-top: 10px;">
                        <div class="col-md-12" align="right">
                          <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Modal description -->
            @empty
              <tr id="modal_count" data-number="1" style="display: none;"></tr>
              <tr>
                <td></td>
                <td><input class="form-control only_eng_and_num" name="new_bill[]" onkeyup="this.value=this.value.toUpperCase();" maxlength="20" required /></td>
                <td><input type="date" class="form-control" id="theDate" name="date_bill[]" value="{{ date('Y-m-d', strtotime("+1 days")) }}" required /></td>
                <td>-</td>
                <td><a data-toggle="modal" data-target="#modalDescriptionNew1" style="text-decoration: none; cursor: pointer;">เพิ่ม</a></td>
              </tr>
            @endforelse
            <tr id="add_bill_row" style="display: none;"></tr>
          </table>
          <div class="row" style="margin-top: 15px;">
            <div class="col-md-12" align="right">
              <a id="add_bill" class="btn btn-default btn-sm" style="background-color: #DEDEDE;"><i class="fas fa-plus"></i>&nbsp;&nbsp;เพิ่มช่อง</a>
            </div>
          </div>
          <div class="row" style="margin-top: 25px;">
            <div class="col-md-12" align="center">
              <a href="{{ url('open-bill/create') }}" class="btn btn-default" style="background-color: #DEDEDE;"><i class="fas fa-chevron-circle-left" style="font-size: 14px;"></i>&nbsp;&nbsp;กลับ</a>
              @if(!$bill_details -> isEmpty())
                <a class="btn btn-default" data-toggle="modal" data-target="#request_edit" style="background-color: #DEDEDE;"><i class="fas fa-edit"></i>&nbsp;&nbsp;แก้ไข</a>
              @endif
              <button type="submit" class="btn btn-success"><i class="fas fa-check-circle"></i>&nbsp;&nbsp;เสร็จสิ้น</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Modal -->
  <div id="request_edit" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12" align="center">
              <i class="fas fa-lock" style="font-size: 40px;"></i>
            </div>
          </div>
          <div id="request_edit_alert" class="alert alert-danger alert-dismissible" role="alert" style="margin-top: 17px; display: none;">
            <button id="request_edit_alert_close" type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>ผิดพลาด !</strong>&nbsp;&nbsp;ไม่สามารถแก้ไขได้
          </div>
          <hr>
          <div class="row" style="margin-top: -10px;">
            <div class="col-md-12">
              <label>รหัสพนักงาน</label>
              <input type="text" id="request_edit_input_usercode" class="form-control request_edit_input" onkeyup="this.value=this.value.toUpperCase();" name="" />
            </div>
            <div class="col-md-12" style="margin-top: 7px;">
              <label>รหัสผ่าน</label>
              <input type="password" id="request_edit_input_password" class="form-control request_edit_input" name="" />
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <a class="btn btn-default" data-dismiss="modal">ยกเลิก</a>
          <a id="request_edit_btn" class="btn btn-success">ยืนยัน</a>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script>
    var nextDay = new Date();
    nextDay.setDate(nextDay.getDate() + 1);
    var month = nextDay.getMonth() + 1;
    var day = nextDay.getDate();
    var year = nextDay.getFullYear();
    if (month < 10) { month = "0" + month }
    if (day < 10) { day = "0" + day }
    var tomorrow;
    var number;
    $(document).ready(function() {
      number = $('#modal_count').data('number');
    });
    function renderHTML(number, tomorrow) {
      let numberHTML = number;
      let todayHTML = tomorrow;
      let table_row = '';
      table_row += '<tr class="table-bill-row">';
        table_row += '<td><a href="#" class="close-bill-input" data-close="'+numberHTML+'">ลบ</a></td>';
        table_row += '<td><input class="form-control only_eng_and_num" name="new_bill[]" onkeyup="this.value=this.value.toUpperCase();" maxlength="20" required /></td>';
        table_row += '<td><input type="date" class="form-control" id="theDate" name="date_bill[]" value="'+todayHTML+'" required /></td>';
        table_row += '<td>-</td>';
        table_row += '<td><a data-toggle="modal" data-target="#modalDescriptionNew'+numberHTML+'" style="text-decoration: none; cursor: pointer;">เพิ่ม</a></td>';
      table_row += '</tr>';
      let modal_description = '';
      modal_description += '<div id="modalDescriptionNew'+numberHTML+'" class="modal fade" role="dialog">';
        modal_description += '<div class="modal-dialog modal-md">';
          modal_description += '<div class="modal-content">';
            modal_description += '<div class="modal-header">';
              modal_description += '<button type="button" class="close" data-dismiss="modal">&times;</button>';
              modal_description += '<h5 class="modal-title" style="font-weight: bold;">กรอกหมายเหตุ</h5>';
            modal_description += '</div>';
            modal_description += '<div class="modal-body">';
              modal_description += '<div class="row">';
                modal_description += '<div class="col-md-12">';
                  modal_description += '<input type="text" class="form-control description_bill" name="description_bill[]" value="-" />';
                modal_description += '</div>';
              modal_description += '</div>';
              modal_description += '<div class="row" style="margin-top: 10px;">';
                modal_description += '<div class="col-md-12" align="right">';
                  modal_description += '<button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>';
                modal_description += '</div>';
              modal_description += '</div>';
            modal_description += '</div>';
          modal_description += '</div>';
        modal_description += '</div>';
      modal_description += '</div>';
      $('#add_bill_row').before(table_row);
      $('#modal_description_new').before(modal_description);
    }

    $(document).on('click', '#add_bill', function() {
      tomorrow = year + "-" + month + "-" + day;
      if(number != null && number != '') {
        number = number + 1;
      } else {
        number = 1;
      }
      renderHTML(number, tomorrow);
    });

    $(document).on('click','.close-bill-input', function(e) {
      e.preventDefault();
      let close_id = $(this).data('close');
      $('#modalDescriptionNew'+close_id).remove();
      $(this).parents('.table-bill-row').remove();
    });

    // ปิด alert
    $('#request_edit_alert_close').click(function() {
      $('#request_edit_alert').fadeOut(500);
    });

    // กดปุ่มยืนยันการแก้ไข
    $('#request_edit_btn').click(function() {
      let cus_id = $('#cus_id').val();
      let usercode = $('#request_edit_input_usercode').val();
      let password = $('#request_edit_input_password').val();
      if(usercode == '' || usercode == null) {
        alert('กรุณาใส่รหัสพนักงาน');
        $('#request_edit_input_usercode').focus();
      } else if(password == '' || password == null) {
        alert('กรุณาใส่รหัสผ่าน');
        $('#request_edit_input_password').focus();
      } else if(usercode && password) {
        $.ajax({
          url: '/ajax/request-bill-detail-edit',
          type: 'GET',
          dataType: 'JSON',
          data: {usercode: usercode, password: password},
          success: function(response) {
            if(response == 0) {
              $('#request_edit_alert').fadeIn(500);
              $('.request_edit_input').addClass('request_edit_input_alert');
            } else if(response == 1) {
              let location = "{{ URL::to('open-bill/create/edit?cus_id=') }}" + cus_id;
              console.log(location);
              window.location.href = location;
            }
          },
          error: function(response) {
            console.log('ไม่สามารถติดต่อ server ได้');
          }
        });
      }
    });

    $(document).on('keyup', '.description_bill', function() {
      let test = $(this).val();
      if(test !== '' && test !== null) {
        //
      } else {
        $(this).val('-');
      }
    });

    $(document).on('keyup', '.request_edit_input', function() {
      $('.request_edit_input').removeClass('request_edit_input_alert')
      $('#request_edit_alert').hide(500);
    });

  </script>
@endsection
