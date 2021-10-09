<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- for ajax post data --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>:: wlp-01 | @yield('title') ::</title>

    <!-- integrate css -->
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-4.1.3/bootstrap.min.css') }}"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-3.3.7/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/autocomplete/easy-autocomplete.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery-confirm-3.3.0/jquery-confirm.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/customs-css.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('font/MaterialDesignIcon/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('font/fontawesome-5.4.1/css/all.min.css') }}">
    <!-- custom css -->
    @yield('stylesheet')
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        font-family: 'K2D', sans-serif;
      }
      .wlp_link {
        margin-top: 7px;
      }
      /* data table */
      table {
        width: 100%;
      }
      th {
        text-align: center;
      }
      td {
        text-align: center;
      }
      /* custom table */
      .custom_table {
        width: 100%;
        border: 1px solid black;
      }
      .custom_table th {
        text-align: center;
        padding: 5px;
        border: 1px solid black;
        background-color: #EFEFEF;
      }
      .custom_table td {
        text-align: center;
        padding: 5px;
      }
      @@media only screen and (max-width: 767px) {
        .content__box_responsive {
          margin-top: 10px;
        }
      }
      @@media only screen and (min-width: 460px) {
        .form__responsive {
          padding-left: 70px;
          padding-right: 70px;
          padding-top: 25px;
        }
      }
      .alert_input_change_pass {
        border: 1px solid #FF5353;
        background-color: #FFD2D2;
      }
    </style>
  </head>
  <body style="background-color: #F7FCFF;" onload="startTime()">
    @php($authenticate = Session::get('authenticate'))
    <div class="container">
      <!-- Header -->
      <div class="row" style="margin-top: 5px;">
        <div class="col-md-3 col-sm-3">
          <div class="section1_wrapper">
            <div class="section1_box">
              <img title="brand_img" src="{{ asset('img/brand_logo/logo_wlp.png') }}" width="90" height="78" style="object-fit: cover;" />
            </div>
          </div>
        </div>
        <div class="col-md-6 col-sm-6">
          <div class="section2_wrapper">
            <div class="section2_box">
              <label style="font-size: 22px; margin-bottom: 7px;">Wellekpharma Packing System</label>
              <br>
              <span style="font-size: 14px;">วันที่ :&nbsp;<span id="demonew" style="font-size: 14px;"></span></span>
              <br>
              <span style="font-size: 14px;">เวลา :&nbsp;<span id="txt" style="font-size: 14px;"></span> น.</span>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-3">
          <div class="section3_wrapper">
            <div class="section3_box">
              <div class="row">
                <div class="col-md-12">
                  <label style="font-size: 15px;"><a style="color: #313131; cursor: pointer;" data-toggle="modal" data-target="#profile_user">{{ "คุณ" . $authenticate -> emp_firstname . " " . $authenticate -> emp_lastname }}</a></label><br>
                  <label style="font-size: 15px;">{{ "(" . $authenticate -> get_role_name -> role_name_th . ")" }}</label>
                </div>
                <div class="col-md-12" style="margin-top: 6px;">
                  <a class="btn btn-default" href="{{ url('/logout') }}" style="color: white; background-color: #C0C0C0;"><i class="fas fa-sign-out-alt"></i>&nbsp;ออกจากระบบ</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- End Header -->

      <div class="row" style="margin-bottom: 20px;">
    		<div class="col-md-3 col-sm-3">
          <div class="menu__box">
            <div class="profile-sidebar" style="border: 1px solid #E8E8E8;">
      				<div class="profile-usertitle">
      					<div class="profile-usertitle-name">เมนูจัดการ</div>
      				</div>
      				<div class="profile-usermenu">
      					<ul id="navbar" class="nav">
                  <!-- openbill -->
                  @if($authenticate -> emp_role == 1)
                    <li><a href="{{ url('/') }}"><i class="fas fa-circle" style="font-size: 6px;"></i>หน้าแรก</a></li>
                    <li><a href="{{ route('open-bill.create') }}"><i class="fas fa-circle" style="font-size: 6px;"></i>ออกบิล</a></li>
                  @endif
                  <!-- qc -->
                  @if($authenticate -> emp_role == 2)
                    <li>
                      <a href="{{ route('quality-control.index') }}"><i class="fas fa-circle" style="font-size: 6px;"></i>รายการที่รอตรวจสอบ
                        @if(isset($wait_qc_count))
                          {{ "(" . $wait_qc_count . ")" }}
                        @else
                          (0)
                        @endif
                      </a>
                    </li>
                    <li>
                      <a href="{{ route('quality-control-wait-to-pack.index') }}"><i class="fas fa-circle" style="font-size: 6px;"></i>รายการที่รอแพ็ค
                        @if(isset($wait_to_pack))
                          {{ "(" . $wait_to_pack . ")" }}
                        @else
                          (0)
                        @endif
                      </a>
                    </li>
                    {{-- <li>
                      <a href="{{ route('quality-control-end-to-pack.index') }}"><i class="fas fa-circle" style="font-size: 6px;"></i>รายการที่กำลังแพ็ค
                        @if(isset($finish_to_pack))
                          {{ "(" . $finish_to_pack . ")" }}
                        @else
                          (0)
                        @endif
                      </a>
                    </li> --}}
                    <li>
                      <a href="{{ route('quality-control-finish.index') }}"><i class="fas fa-circle" style="font-size: 6px;"></i>รายการที่พร้อมส่ง
                        @if(isset($wait_to_send))
                          {{ "(" . $wait_to_send . ")" }}
                        @else
                          (0)
                        @endif
                      </a>
                    </li>
                    <li>
                      <a href="{{ url('quality-control-rejects') }}" style="color: red;"><i class="fas fa-circle" style="font-size: 6px;"></i>รายการที่ต้องแก้ไข
                        @if(isset($reject_coute))
                          {{ "(" . $reject_coute . ")" }}
                        @else
                          (0)
                        @endif
                      </a>
                    </li>
                  @endif
                  <!-- transport -->
                  @if($authenticate -> emp_role == 4)
                    <li><a href="{{ url('transfer-to-container') }}"><i class="fas fa-circle" style="font-size: 6px;"></i>รายการขึ้นสินค้า</a></li>
                    <li><a href="{{ url('update-bill') }}"><i class="fas fa-circle" style="font-size: 6px;"></i>อัพเดทสถานะการส่งสินค้า</a></li>
                    <li><a href="{{ url('transport-bill') }}"><i class="fas fa-circle" style="font-size: 6px;"></i>กรอกข้อมูลรถขนส่ง</a></li>
                  @endif
                  <!-- sale admin -->
                  @if($authenticate -> emp_role == 6)
                    <li><a href="{{ url('export-bill') }}"><i class="fas fa-circle" style="font-size: 6px;"></i>ออกเลขที่ใบวางบิล</a></li>
                    <li><a href="{{ url('confirm-to-transport') }}"><i class="fas fa-circle" style="font-size: 6px;"></i>คอนเฟริมแผนกขนส่ง</a></li>
                    <li><a href="{{ url('report-bill') }}"><i class="fas fa-circle" style="font-size: 6px;"></i>พิมพ์ใบรายงาน</a></li>
                  @endif
                  <!-- admin -->
                  @if($authenticate -> emp_role == 9)
                    <li><a href="{{ url('customers-management') }}"><i class="fas fa-circle" style="font-size: 6px;"></i>จัดการรายชื่อลูกค้า</a></li>
                    <li><a href="{{ url('employee-management') }}"><i class="fas fa-circle" style="font-size: 6px;"></i>จัดการรายชื่อพนักงาน</a></li>
                  @endif
                  @if($authenticate -> emp_role == 10)
                    <li>
                      <a href="{{ route('quality-control-reject.index') }}" style="color: red;"><i class="fas fa-circle" style="font-size: 6px;"></i>รายการที่ต้องแก้ไข
                        @if(isset($reject_coute))
                          {{ "(" . $reject_coute . ")" }}
                        @else
                          (0)
                        @endif
                      </a>
                    </li>
                  @endif
      					</ul>
      				</div>
      			</div>
          </div>
    		</div>
    		<div class="col-md-9 col-sm-9 content__box_responsive">
          <div class="content__box">
            <div class="profile-content" style="border: 1px solid #E8E8E8;">
      			   @yield('content')
            </div>
          </div>
    		</div>
    	</div>
      <!-- Modal -->
      <div id="profile_user" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12" align="center">
                  <div class="avatar">
                   <a>
                     @if(!empty($authenticate -> emp_image))
                       <img src="{{ asset('img/profile_img/' . $authenticate -> emp_image) }}" class="user"/>
                     @else
                       <img src="{{ asset('img/profile_img/profile_default.png') }}" class="user"/>
                     @endif
                   </a>
                  </div>
                </div>
              </div>
              <div class="row" style="margin-top: 4px;">
                <div class="col-md-offset-2 col-xs-offset-2 col-md-8 col-xs-8">
                  <div class="row" style="margin-bottom: 9px;">
                    <div class="col-md-12 text-center">
                      <label style="margin: 3px;">คุณ{{ $authenticate -> emp_firstname . " " . $authenticate -> emp_lastname }}</label><br>
                      <label style="margin: 3px;">({{ $authenticate -> get_role_name -> role_name_th }})</label><br>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-md-8 col-xs-8">
                      <i class="fas fa-key" style="color: #FAD034; font-size: 15px"></i>&nbsp;<label>&nbsp;เปลี่ยนรหัสผ่าน</label>
                    </div>
                    <div class="col-md-4 col-xs-4" align="right">
                      <a id="toggle_btn" style="cursor: pointer;">กดที่นี่</a>
                    </div>
                    <div class="row hidden-form" style="display: none;">
                      <form id="formchangepassword" action="{{ url('/change-pass-data') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" id="emp_id" name="emp_id" value="{{ $authenticate -> id }}">
                        <div class="col-md-12" style="margin-top: 14px; margin-bottom: 12px;">
                          <div class="form-group">
                            <label class="control-label col-sm-6" for="" style="font-weight: normal;">รหัสผ่านเก่า :</label>
                            <div class="col-sm-6">
                              <input type="password" class="form-control" id="old_password" name="old_password" required>
                            </div>
                          </div>
                        </div>
                        <br>
                        <div class="col-md-12" style="margin-bottom: 6px;">
                          <div class="form-group">
                            <label class="control-label col-sm-6" for="" style="font-weight: normal;">รหัสผ่านใหม่ :</label>
                            <div class="col-sm-6">
                              <input type="password" class="form-control" id="new_password" name="new_password" required placeholder="ไม่น้อยกว่า 4 ตัวอักษร">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label class="control-label col-sm-6" for="" style="font-weight: normal;">รหัสผ่านใหม่ (อีกครั้ง) :</label>
                            <div class="col-sm-6">
                              <input type="password" class="form-control" id="new_password_again" name="new_password_again" required placeholder="ไม่น้อยกว่า 4 ตัวอักษร">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12" style="margin-top: 14px;">
                          <div class="form-group">
                            <div class="col-sm-12" align="center">
                              <button type="submit" class="btn btn-success" onclick="return checkChangePassFunc(event);"><i class="fas fa-check-circle"></i>&nbsp;&nbsp;ยืนยันการเปลี่ยน</button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  <hr>
                </div>
              </div>
              <div class="row" align="right" style="margin-top: 6px;">
                <div class="col-md-12">
                  <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- integrate javascript -->
    <script type="text/javascript" src="{{ asset('js/jquery-1.12.4/jquery-1.12.4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-confirm-3.3.0/jquery-confirm.min.js') }}"></script>
    {{-- <script type="text/javascript" src="{{ asset('js/bootstrap-4.1.3/bootstrap.min.js') }}"></script> --}}
    <script type="text/javascript" src="{{ asset('js/bootstrap-3.3.7/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/autocomplete/jquery.easy-autocomplete.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/customs-js.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/moment.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/moment-local.js') }}"></script>
    <!-- custom javascript -->
    @yield('script')
    <script>
      // Datable Table
      $(document).ready(function () {
        $('#example').DataTable({
          "paging": false,
          "oLanguage": {
            "sProcessing": "กำลังดำเนินการ...",
            "sLengthMenu": "แสดง : _MENU_ &nbsp;เร็คคอร์ด",
            "sZeroRecords": "ไม่พบข้อมูล",
            "sInfo": "แสดง _START_ ถึง _END_ จาก _TOTAL_ เร็คคอร์ด",
            "sInfoEmpty": "แสดง 0 ถึง 0 จาก 0 แถว",
            "sInfoFiltered": "(กรองข้อมูล _MAX_ ทุกแถว)",
            "sInfoPostFix": "",
            "sSearch": "ค้นหา :",
            "sUrl": "",
            "oPaginate": {
              "sFirst": "เริ่มต้น",
              "sPrevious": "ก่อนหน้า",
              "sNext": "ถัดไป",
              "sLast": "สุดท้าย"
            }
          }
        });
      });
      // $.extend( $.fn.dataTable.defaults, {
      //   ordering:  false
      // });

      // ajax initialize
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      // Active Menu
      var str = location.href.toLowerCase();
      $("#navbar li a").each(function() {
        if(str.indexOf($(this).attr("href").toLowerCase()) > -1) {
          $("li.active").removeClass("active");
          $(this).parent().addClass("active");
        }
      });
      $("li.active").parents().each(function() {
        if($(this).is("li")) {
          $(this).addClass("active");
        }
      });

      //กรอกได้เฉพาะตัวเลขและตัวอักษรภาษาอังกฤษ
      $(document).on('keypress', '.only_eng_and_num', function() {
        var ew = event.which;
        if(ew == 32)
          return true;
        if(48 <= ew && ew <= 57)
          return true;
        if(65 <= ew && ew <= 90)
          return true;
        if(97 <= ew && ew <= 122)
          return true;
        return false;
      });

      // กรอกได้เฉพาะตัวเลขและจุด
      function isNumberOrDot(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if(charCode == 46) {
          return true;
        } else if(charCode > 31 && (charCode < 48 || charCode > 57)) {
          return false;
        }
        return true;
      }

      // กรอกได้เฉพาะตัวเลข
      function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
          return false;
        }
        return true;
      }

      //วันที่
      let today_clock = new Date();
      let dd = today_clock.getDate();
      let mm = today_clock.getMonth();
      let yyyy = today_clock.getFullYear();

      if(dd < 10) { dd = '0' + dd }

      // if(mm < 10) { mm = '0' + mm }

      let thmonth = new Array("มกราคม", "กุมภาพันธ์", "มีนาคม",
      "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน",
      "ตุลาคม", "พฤศจิกายน", "ธันวาคม");

      today_clock = dd + ' ' + thmonth[mm] + ' ' + (yyyy + 543);
      document.getElementById("demonew").innerHTML = today_clock;

      //นับเวลา Time
      function startTime() {
          let today_clock = new Date();
          let h = today_clock.getHours();
          let m = today_clock.getMinutes();
          let s = today_clock.getSeconds();
          m = checkTime(m);
          s = checkTime(s);
          document.getElementById('txt').innerHTML = h + ":" + m + ":" + s;
          let t = setTimeout(startTime, 500);
      }
      function checkTime(i) {
          if (i < 10) { i = "0" + i };  // add zero in front of numbers < 10
          return i;
      }

      $('#toggle_btn').click(function(event) {
        $('.hidden-form').toggle(300);
      });
      $(document).on('keyup', '#old_password, #new_password, #new_password_again', function() {
        $(this).removeClass('alert_input_change_pass');
      });
      function checkChangePassFunc(e) {
        e.preventDefault();
        let emp_id = $('#emp_id').val();
        let old_pass = $('#old_password').val();
        let new_pass = $('#new_password').val();
        let new_pass_again = $('#new_password_again').val();
        let to_submit = 4;
        $.ajax({
          url: '/ajax/old-pass-check',
          type: 'GET',
          dataType: 'JSON',
          data: {old_pass: old_pass, emp_id: emp_id},
          success: function(response) {
            if(response === 'false') {
              $('#old_password').addClass('alert_input_change_pass');
              to_submit -= 1;
            }
          },
          error: function(response) {
            console.log('ไม่สามารถติดต่อ server ได้');
          }
        });
        if(new_pass.length < 4) {
          $('#new_password').addClass('alert_input_change_pass');
          to_submit -= 1;
        }
        if(new_pass_again.length < 4) {
          $('#new_password_again').addClass('alert_input_change_pass');
          to_submit -= 1;
        }
        if(new_pass == '' && new_pass_again == '') {
          $('#new_password').addClass('alert_input_change_pass');
          $('#new_password_again').addClass('alert_input_change_pass');
          to_submit -= 1;
        } else if(new_pass !== new_pass_again) {
          $('#new_password').addClass('alert_input_change_pass');
          $('#new_password_again').addClass('alert_input_change_pass');
          to_submit -= 1;
        } else {
          $('#new_password').removeClass('alert_input_change_pass');
          $('#new_password_again').removeClass('alert_input_change_pass');
        }
        submitChangPass(to_submit);
      }
      function submitChangPass(param) {
        if(param == 4) {
          $('#formchangepassword').submit();
        }
      }
    </script>
  </body>
</html>
