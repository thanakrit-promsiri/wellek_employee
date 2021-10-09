@extends('layouts.master')

@section('title', 'จัดการรายชื่อพนักงาน')

@section('stylesheet')
  <style>
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
    .alert_input {
      border: 1px solid #FF5353;
      background-color: #FFD2D2;
    }
  </style>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-12 col-sm-12 form__responsive">
          <div class="row">
            <div class="col-md-7 col-sm-7">
              <label style="font-size: 19px;">รายชื่อพนักงานทั้งหมด</label>
            </div>
            <div class="col-md-5 col-sm-5" align="right">
              <button class="btn new-bg" data-toggle="modal" data-target="#insertEmployee"><i class="fas fa-plus"></i>&nbsp;&nbsp;เพิ่มพนักงาน</button>
            </div>
          </div>
          <hr>
        </div>
      </div>
      <table id="example" class="display">
        <thead>
          <tr>
            <th width="5%">&nbsp;</th>
            <th width="8%">รหัส</th>
            <th>ชื่อพนักงาน</th>
            <th width="20%">เบอร์โทร</th>
            <th width="15%">ตำแหน่ง</th>
            <th width="5%">&nbsp;</th>
          </tr>
        </thead>
        <tbody>
          @php($no = 1)
          @foreach($employees as $employee)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $employee -> emp_code }}</td>
              <td>{{ "คุณ" . $employee -> emp_firstname . " " . $employee -> emp_lastname }}</td>
              <td>{{ $employee -> emp_phone ? $employee -> emp_phone : "-" }}</td>
              <td>{{ $employee -> get_role_name -> role_name_th }}</td>
              <td><a href="#" data-toggle="modal" data-target="#empModal"><i class="fas fa-search" style="font-size: 13px;"></i></a></td>
            </tr>
          @endforeach
        <tbody>
      </table>
      <!-- Modal Add -->
      <div class="modal fade" id="insertEmployee" role="dialog">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h5 class="modal-title" style="font-weight: bold;">เพิ่มพนักงาน</h5>
            </div>
            <div class="modal-body">
              <div class="wrapper_modal">
                <form id="myform" action="{{ url('/employee-insert-data') }}" method="post">
                  {{ csrf_field() }}
                  <div class="row">
                    <div class="col-md-12 form-margin">
                      <div class="form-group">
                        <label class="control-label col-sm-3" for="">แผนก :</label>
                        <div class="col-sm-9">
                          {{ Form::select('emp_role', $roles, null, array('class' => 'form-control', 'id' => 'emp_role', 'placeholder' => 'เลือกแผนก', 'required' => '')) }}
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12 form-margin">
                      <div class="form-group">
                        <label class="control-label col-sm-3" for="">รหัสพนักงาน :</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control" id="emp_short_code" name="emp_short_code" placeholder="-" readonly>
                        </div>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="emp_code" name="emp_code" maxlength="4" required onkeypress="return isNumber(event);">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12 form-margin">
                      <div class="form-group">
                        <label class="control-label col-sm-3" for="">ชื่อจริง :</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="" name="emp_firstname" required>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12 form-margin">
                      <div class="form-group">
                        <label class="control-label col-sm-3" for="">นามสกุล :</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="" name="emp_lastname" required>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12 form-margin">
                      <div class="form-group">
                        <label class="control-label col-sm-3" for="">เบอร์โทร :</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="" name="emp_tel" onkeypress="return isNumber(event);">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12 form-margin">
                      <div class="form-group">
                        <label class="control-label col-sm-3" for="">รหัสผ่าน :</label>
                        <div class="col-sm-9">
                          <input type="password" class="form-control" id="emp_password" name="emp_password" maxlength="10" required placeholder="ไม่น้อยกว่า 4 ตัวอักษร">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12 form-margin" align="right">
                      <div class="form-group">
                        <div class="col-sm-12" style="padding-top: 12px;">
                          <button type="submit" class="btn btn-success" onclick="return validateFunc(event);"><i class="fas fa-save"></i>&nbsp;&nbsp;บันทึก</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal -->
    </div>
  </div>
@endsection

@section('script')
  <script>
    $(document).on('change', '#emp_role', function(event) {
      let emp_role_id = $('#emp_role').val();
      if(emp_role_id !== null && emp_role_id !== '') {
        $.ajax({
          url: '/ajax/get-role-short-code',
          type: 'GET',
          dataType: 'JSON',
          data: {emp_role_id: emp_role_id},
          success: function(response) {
            $('#emp_short_code').val(response.role_name_short);
          },
          error: function(response) {
            console.log('ไม่สามารถติดต่อ server ได้');
          }
        });
      } else {
        $('#emp_short_code').val('');
        $('#emp_short_code').placeholder('-');
      }
    });

    function validateFunc(e) {
      e.preventDefault();
      let emp_full_code = $('#emp_short_code').val() + '' + $('#emp_code').val();
      let emp_password = $('#emp_password').val();
      let count = 2;
      $.ajax({
        url: '/ajax/check-emp-code',
        type: 'GET',
        dataType: 'JSON',
        data: {emp_full_code: emp_full_code},
        success: function(response) {
          if(response === 'fail') {
            $('#emp_code').addClass('alert_input');
            return false;
          } else {
            myFunc(count = count - 1);
          }
        },
        error: function(response) {
          console.log('ไม่สามารถติดต่อ server ได้');
        }
      });
      if(emp_password.length < 4) {
        $('#emp_password').addClass('alert_input');
        return false;
      } else {
        myFunc(count = count - 1);
      }
    }

    function myFunc(param) {
      if(param == 0) {
        $('#myform').submit();
      }
    }

    $(document).on('keyup', '#emp_code, #emp_password', function(event) {
      $(this).removeClass('alert_input');
    });
  </script>
@endsection
