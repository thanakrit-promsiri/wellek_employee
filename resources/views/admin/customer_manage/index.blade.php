@extends('layouts.master')

@section('title', 'จัดการรายชื่อลูกค้า')

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
  </style>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-12 col-sm-12 form__responsive">
          <div class="row">
            <div class="col-md-7 col-sm-7">
              <label style="font-size: 19px;">รายชื่อลูกค้าทั้งหมด</label>
            </div>
            <div class="col-md-5 col-sm-5" align="right">
              <button class="btn new-bg" data-toggle="modal" data-target="#insertCustomer"><i class="fas fa-plus"></i>&nbsp;&nbsp;เพิ่มลูกค้า</button>
            </div>
          </div>
          <hr>
        </div>
      </div>
      <table id="example" class="display">
        <thead>
          <tr>
            <th width="5%">&nbsp;</th>
            <th width="7%">สาย</th>
            <th width="15%">รหัสลูกค้า</th>
            <th>ชื่อลูกค้า</th>
            <th width="15%">ลำดับสายส่ง</th>
          </tr>
        </thead>
        <tbody>
          @php($no = 1)
          @foreach($customer_routes as $customer_route)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $customer_route -> get_route -> route_code }}</td>
              <td>{{ $customer_route -> get_customer -> cus_code }}</td>
              <td>{{ $customer_route -> get_customer -> cus_name }}</td>
              <td>{{ $customer_route -> cus_route_order }}</td>
            </tr>
          @endforeach
        <tbody>
      </table>
      <!-- Modal View -->
      <div class="modal fade" id="insertCustomer" role="dialog">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h5 class="modal-title" style="font-weight: bold;">เพิ่มลูกค้า</h5>
            </div>
            <div class="modal-body">
              <div class="wrapper_modal">
                <form action="{{ url('/customers-insert-data') }}" method="post">
                {{ csrf_field() }}
                  <div class="row">
                    <div class="col-md-12 form-margin">
                      <div class="form-group">
                        <label class="control-label col-sm-3" for="">รหัสลูกค้า :</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="" name="cus_code" required>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12 form-margin">
                      <div class="form-group">
                        <label class="control-label col-sm-3" for="">ชื่อลูกค้า :</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="" name="cus_name" required>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12 form-margin">
                      <div class="form-group">
                        <label class="control-label col-sm-3" for="">ที่อยู่ลูกค้า :</label>
                        <div class="col-sm-9">
                          <textarea class="form-control" id="" rows="4" cols="3" name="cus_address" required></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12 form-margin">
                      <div class="form-group">
                        <label class="control-label col-sm-3" for="">เบอร์โทรที่ 1 :</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="" name="cus_tel1">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12 form-margin">
                      <div class="form-group">
                        <label class="control-label col-sm-3" for="">เบอร์โทรที่ 2 :</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="" name="cus_tel2">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12 form-margin">
                      <div class="form-group">
                        <label class="control-label col-sm-3" for="">เบอร์โทรที่ 3 :</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="" name="cus_tel3">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12 form-margin">
                      <div class="form-group">
                        <label class="control-label col-sm-3" for="">เลือกสาย :</label>
                        <div class="col-sm-9">
                          {{ Form::select('route_id', $routes, null, array('class' => 'form-control', 'placeholder' => 'เลือกสาย')) }}
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12 form-margin">
                      <div class="form-group">
                        <label class="control-label col-sm-3" for="">ลำดับในสาย :</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="" name="cus_route_order">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12 form-margin" align="right">
                      <div class="form-group">
                        <div class="col-sm-12" style="padding-top: 12px;">
                          <button type="submit" class="btn btn-success"><i class="fas fa-save"></i>&nbsp;&nbsp;บันทึก</button>
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
    //
  </script>
@endsection
