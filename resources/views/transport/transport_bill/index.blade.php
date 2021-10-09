@extends('layouts.master')

@section('title', 'กรอกข้อมูลรถขนส่ง')

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
      border: 1px solid #B8B8B8;
    }
    .form-margin {
      margin-top: 5px;
      margin-bottom: 5px;
    }
    .control-label {
      font-weight: normal;
      margin-top: 5px;
    }
    .control-label-checkbox {
      font-weight: normal;
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
    .form-content {
      width: 100%;
      padding: 6px;
      background-color: #EDEDED;
      border-radius: 6px;
    }
  </style>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12 col-sm-12">
      @if(Session::has('noti'))
        <div class="alert alert-success alert-dismissible">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong><i class="fas fa-exclamation-triangle"></i></strong>&nbsp;&nbsp;{{ Session::get('noti') }}
        </div>
      @endif
      <div class="row">
        <div class="col-md-12 col-sm-12 form__responsive">
          <div class="row">
            <div class="col-md-7 col-sm-7">
              <label style="font-size: 19px;">กรอกข้อมูลรถขนส่ง</label>
            </div>
            {{-- <div class="col-md-5 col-sm-5" align="right">
              <button id="status_btn" class="btn new-bg" data-toggle="modal" data-target="#insertFinalBill" disabled><i class="far fa-edit"></i>&nbsp;&nbsp;กรอกเลขที่ใบวางบิล</button>
            </div> --}}
          </div>
          <hr>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12" style="padding: 30px;">
          <div class="stepwizard">
            <div class="stepwizard-row setup-panel">
              <div class="stepwizard-step">
                <a href="#step-1" type="button" class="btn btn-primary btn-circle">1</a>
                <p>ขั้นที่ 1</p>
              </div>
              <div class="stepwizard-step">
                <a href="#step-2" type="button" class="btn btn-default btn-circle">2</a>
                <p>ขั้นที่ 2</p>
              </div>
              <div class="stepwizard-step">
                <a href="#step-3" type="button" class="btn btn-default btn-circle">3</a>
                <p>ยืนยัน</p>
              </div>
            </div>
          </div>
          <form action="{{ url('/save-transport-bill') }}" method="POST" role="form">
          {{ csrf_field() }}
            <div class="row setup-content" id="step-1">
              <div class="col-xs-12 col-md-12" style="padding-top: 15px;">
                <h5 style="font-weight: bold;">กรอกข้อมูลสังเขป</h5>
                <div class="row">
                  <div class="col-md-6 form-margin">
                    <div class="form-group">
                      <label class="control-label col-sm-4" for="emp_id">พนง.ขับ&nbsp;&nbsp;&nbsp;:</label>
                      <div class="col-sm-8">
                        <div class="input-group">
                          <input type="text" class="form-control only_eng_and_num" id="emp_id" name="emp_id" aria-describedby="basic-addon2" placeholder="รหัสพนง." onkeyup="this.value=this.value.toUpperCase();" required>
                          <span class="input-group-addon" id="basic-addon2"><i class="fas fa-check-circle" style="color: #B4B4B4;"></i></span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 form-margin">
                    <div class="form-group">
                      <label class="control-label col-sm-4" for="">สายส่ง&nbsp;&nbsp;&nbsp;:</label>
                      <div class="col-sm-8">
                        {!! Form::select('route_id', $routes, null, ['class' => 'form-control', 'placeholder' => 'สายส่ง', 'required' => 'required']) !!}
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 form-margin">
                    <div class="form-group">
                      <label class="control-label col-sm-4" for="">ทะเบียน&nbsp;&nbsp;&nbsp;:</label>
                      <div class="col-sm-8">
                        {!! Form::select('car_id', $car_licenses, null, ['class' => 'form-control', 'placeholder' => 'ทะเบียน', 'required' => 'required']) !!}
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 form-margin">
                    <div class="form-group">
                      <label class="control-label col-sm-4" for="travel_date">วันที่&nbsp;&nbsp;&nbsp;:</label>
                      <div class="col-sm-8">
                        <input type="date" class="form-control" name="travel_date" id="travel_date" value="{{ date('Y-m-d', strtotime("now")) }}" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 form-margin">
                    <div class="form-group">
                      <label class="control-label col-sm-4" for="brunch_number">สาขาที่&nbsp;&nbsp;&nbsp;:</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="brunch_number" id="brunch_number" onkeypress="return isNumber(event);" required>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 form-margin">
                    <div class="form-group">
                      <label class="control-label col-sm-4" for="emp_lift_id">พนง.ยก&nbsp;&nbsp;&nbsp;:</label>
                      <div class="col-sm-8">
                        <div class="input-group">
                          <input type="text" class="form-control only_eng_and_num" id="emp_lift_id" name="emp_lift_id" aria-describedby="basic-addon3" placeholder="รหัสพนง." onkeyup="this.value=this.value.toUpperCase();" required>
                          <span class="input-group-addon" id="basic-addon3"><i class="fas fa-check-circle" style="color: #B4B4B4;"></i></span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12 form-margin" align="right">
                    <div class="form-group">
                      <div class="col-sm-12" style="margin-top: 12px;">
                        <button class="btn btn-primary nextBtn pull-right" type="button">ถัดไป</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row setup-content" id="step-2">
              <div class="col-xs-12 col-md-12" style="padding-top: 15px;">
                <h5 style="font-weight: bold;">กรอกรายละเอียด</h5>
                <div class="row">
                  <div class="col-md-8" style="padding: 5px;">
                    <div class="form-content">
                      <div class="row">
                        <div class="col-md-12 form-margin">
                          <div class="form-group">
                            <label class="control-label col-sm-5" for="start_time">เวลาเริ่มงาน</label>
                            <div class="col-sm-7">
                              <div class="input-group">
                                <input type="time" class="form-control" name="start_time" id="start_time" required>
                                <span class="input-group-addon">นาที</span>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12 form-margin">
                          <div class="form-group">
                            <label class="control-label col-sm-5" for="depart_time">เวลาที่ออกรถ</label>
                            <div class="col-sm-7">
                              <div class="input-group">
                                <input type="time" class="form-control" name="depart_time" id="depart_time" required>
                                <span class="input-group-addon">นาที</span>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12 form-margin">
                          <div class="form-group">
                            <label class="control-label col-sm-5" for="first_delivery">เวลาส่งงานที่แรก</label>
                            <div class="col-sm-7">
                              <div class="input-group">
                                <input type="time" class="form-control" name="first_delivery" id="first_delivery" required>
                                <span class="input-group-addon">นาที</span>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12 form-margin">
                          <div class="form-group">
                            <label class="control-label col-sm-5" for="last_pick_up">เวลารับงานที่สุดท้าย</label>
                            <div class="col-sm-7">
                              <div class="input-group">
                                <input type="time" class="form-control" name="last_pick_up" id="last_pick_up" required>
                                <span class="input-group-addon">นาที</span>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12 form-margin">
                          <div class="form-group">
                            <label class="control-label col-sm-5" for="return_time">เวลาที่กลับ</label>
                            <div class="col-sm-7">
                              <div class="input-group">
                                <input type="time" class="form-control" name="return_time" id="return_time" required>
                                <span class="input-group-addon">นาที</span>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12 form-margin">
                          <div class="form-group">
                            <label class="control-label col-sm-5" for="finish_time">เวลาเสร็จงาน</label>
                            <div class="col-sm-7">
                              <div class="input-group">
                                <input type="time" class="form-control" name="finish_time" id="finish_time" required>
                                <span class="input-group-addon">นาที</span>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12 form-margin">
                          <div class="form-group">
                            <label class="control-label col-sm-5" for="start_km">ก.ม.ที่เริ่มงาน</label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" name="start_km" id="start_km" onkeypress="return isNumberOrDot(event);" required>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12 form-margin">
                          <div class="form-group">
                            <label class="control-label col-sm-5" for="finish_km">ก.ม.ที่เสร็จงาน</label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" name="finish_km" id="finish_km" onkeypress="return isNumberOrDot(event);" required>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12 form-margin">
                          <div class="form-group">
                            <label class="control-label col-sm-5" for="total_km">ก.ม.ที่วิ่งงาน</label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" name="total_km" id="total_km" onkeypress="return isNumberOrDot(event);" required>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12 form-margin">
                          <div class="form-group">
                            <label class="control-label col-sm-5" for="fuel_cost">ค่าน้ำมันรวม</label>
                            <div class="col-sm-7">
                              <div class="input-group">
                                <input type="text" class="form-control" name="fuel_cost" id="fuel_cost" onkeypress="return isNumberOrDot(event);" required>
                                <span class="input-group-addon">บาท</span>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12 form-margin">
                          <div class="form-group">
                            <label class="control-label col-sm-5" for="total_liter">จำนวนลิตรรวม</label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" name="total_liter" id="total_liter" onkeypress="return isNumberOrDot(event);" required>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12 form-margin">
                          <div class="form-group">
                            <label class="control-label col-sm-5" for="mileage">ระยะ ก.ม.ที่เติม</label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" name="mileage" id="mileage" onkeypress="return isNumberOrDot(event);" required>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12 form-margin">
                          <div class="form-group">
                            <label class="control-label col-sm-5" for="ex_press_way">ค่าทางด่วนรวม</label>
                            <div class="col-sm-7">
                              <div class="input-group">
                                <input type="text" class="form-control" name="ex_press_way" id="ex_press_way" onkeypress="return isNumberOrDot(event);" required>
                                <span class="input-group-addon">บาท</span>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12 form-margin">
                          <div class="form-group">
                            <label class="control-label col-sm-5" for="car_park">ค่าจอดรถรวม</label>
                            <div class="col-sm-7">
                              <div class="input-group">
                                <input type="text" class="form-control" name="car_park" id="car_park" onkeypress="return isNumberOrDot(event);" required>
                                <span class="input-group-addon">บาท</span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4" style="padding: 5px;">
                    <div class="form-content">
                      <div class="row">
                        <div class="col-md-12" align="center">
                          <label style="margin-top: 5px; margin-bottom: 12px;">Vehicle Inspection</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12 form-margin">
                          <div class="form-group">
                            <label class="control-label-checkbox col-sm-10" for="">กระจกรถ</label>
                            <div class="col-sm-2">
                              <input type="checkbox" name="mirror" value="1">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12 form-margin">
                          <div class="form-group">
                            <label class="control-label-checkbox col-sm-10" for="">ไฟรถ</label>
                            <div class="col-sm-2">
                              <input type="checkbox" name="car_light" value="1">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12 form-margin">
                          <div class="form-group">
                            <label class="control-label-checkbox col-sm-10" for="">ไฟเบรค</label>
                            <div class="col-sm-2">
                              <input type="checkbox" name="break_light" value="1">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12 form-margin">
                          <div class="form-group">
                            <label class="control-label-checkbox col-sm-10" for="">ยางรถ</label>
                            <div class="col-sm-2">
                              <input type="checkbox" name="tire" value="1">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12 form-margin">
                          <div class="form-group">
                            <label class="control-label-checkbox col-sm-10" for="">ที่ปัดน้ำฝน</label>
                            <div class="col-sm-2">
                              <input type="checkbox" name="wiper" value="1">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12 form-margin">
                          <div class="form-group">
                            <label class="control-label-checkbox col-sm-10" for="">กุญแจล็อค</label>
                            <div class="col-sm-2">
                              <input type="checkbox" name="key_lock" value="1">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12 form-margin">
                          <div class="form-group">
                            <label class="control-label-checkbox col-sm-10" for="">ยางอะไหล่</label>
                            <div class="col-sm-2">
                              <input type="checkbox" name="spare_tire" value="1">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12 form-margin">
                          <div class="form-group">
                            <label class="control-label-checkbox col-sm-10" for="">น้ำหม้อน้ำ</label>
                            <div class="col-sm-2">
                              <input type="checkbox" name="boiler_water" value="1">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12 form-margin">
                          <div class="form-group">
                            <label class="control-label-checkbox col-sm-10" for="">ผ้าเบรค</label>
                            <div class="col-sm-2">
                              <input type="checkbox" name="brake_pads" value="1">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12 form-margin">
                          <div class="form-group">
                            <label class="control-label-checkbox col-sm-10" for="">น้ำล้างกระจก</label>
                            <div class="col-sm-2">
                              <input type="checkbox" name="glass_cleaner" value="1">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12 form-margin">
                          <div class="form-group">
                            <label class="control-label-checkbox col-sm-10" for="">น้ำมันเครื่อง</label>
                            <div class="col-sm-2">
                              <input type="checkbox" name="engine_oil" value="1">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12 form-margin">
                          <div class="form-group">
                            <label class="control-label-checkbox col-sm-10" for="">น้ำหม้อแบต</label>
                            <div class="col-sm-2">
                              <input type="checkbox" name="battery_water" value="1">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12 form-margin">
                          <div class="form-group">
                            <label class="control-label-checkbox col-sm-10" for="">โทรศัพท์</label>
                            <div class="col-sm-2">
                              <input type="checkbox" name="phone" value="1">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12 form-margin">
                          <div style="margin-top: 10px; margin-left: 10px; margin-right: 10px; margin-bottom: 4px;">
                            <label for="" style="font-weight: normal; margin-bottom: 5px;">หมายเหตุ :</label>
                            <textarea class="form-control" name="description" rows="5"></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6" style="padding: 5px;">
                    <div class="form-content">
                      <div class="row">
                        <div class="col-md-12 form-margin">
                          <div class="form-group">
                            <label class="control-label col-sm-6" for="total_delivery_success">จำนวนงานส่ง :</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <input type="text" class="form-control" name="total_delivery_success" id="total_delivery_success" aria-describedby="basic-addon1" onkeypress="return isNumber(event);" required>
                                <span class="input-group-addon" id="basic-addon1">จุด</span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6" style="padding: 5px;">
                    <div class="form-content">
                      <div class="row">
                        <div class="col-md-12 form-margin">
                          <div class="form-group">
                            <label class="control-label col-sm-6" for="total_delivery_fail">จำนวนงานไม่ได้ส่ง :</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <input type="text" class="form-control" name="total_delivery_fail" id="total_delivery_fail" aria-describedby="basic-addon2" onkeypress="return isNumber(event);" required>
                                <span class="input-group-addon" id="basic-addon2">จุด</span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12" style="margin-top: 12px;">
                    <button class="btn btn-primary nextBtn pull-right" type="button">ถัดไป</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="row setup-content" id="step-3">
              <div class="col-xs-12 col-md-12" align="center" style="margin-top: 25px;">
                <h5 style="font-weight: bold;">ยืนยันการบันทึกข้อมูลทั้งหมด</h5>
                <button class="btn btn-success" type="submit"><i class="fas fa-save"></i>&nbsp;&nbsp;บันทึกข้อมูล</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script>
    $(document).on('keyup', '#emp_id', function() {
      let emp_code_input = $(this).val();
      if(emp_code_input !== '' && emp_code_input !== null) {
        $.ajax({
          url: '/ajax/validate-driver-code',
          type: 'GET',
          dataType: 'JSON',
          data: {emp_code_input: emp_code_input},
          success: function(response) {
            if(response === 'success') {
              $('#basic-addon2').html('<i class="fas fa-check-circle" style="color: #0ABC04;"></i>');
            } else if(response === 'fail') {
              $('#basic-addon2').html('<i class="fas fa-times-circle" style="color: #BC0404;"></i>');
            }
          },
          error: function(response) {
            console.log('ไม่สามารถติดต่อ server ได้');
          }
        });
      } else {
        $('#basic-addon2').html('<i class="fas fa-check-circle" style="color: #B4B4B4;"></i>');
      }
    });
    $(document).on('keyup', '#emp_lift_id', function() {
      let emp_lift_code_input = $(this).val();
      if(emp_lift_code_input !== '' && emp_lift_code_input !== null) {
        $.ajax({
          url: '/ajax/validate-driver-lift-code',
          type: 'GET',
          dataType: 'JSON',
          data: {emp_lift_code_input: emp_lift_code_input},
          success: function(response) {
            if(response === 'success') {
              $('#basic-addon3').html('<i class="fas fa-check-circle" style="color: #0ABC04;"></i>');
            } else if(response === 'fail') {
              $('#basic-addon3').html('<i class="fas fa-times-circle" style="color: #BC0404;"></i>');
            }
          },
          error: function(response) {
            console.log('ไม่สามารถติดต่อ server ได้');
          }
        });
      } else {
        $('#basic-addon3').html('<i class="fas fa-check-circle" style="color: #B4B4B4;"></i>');
      }
    });
  </script>
@endsection
