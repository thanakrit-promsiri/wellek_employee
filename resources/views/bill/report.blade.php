@extends('layouts.master')

@section('title', 'รายงานบิล')

@section('stylesheet')
  <style>
    .wrapper {
      margin: 15px;
    }
  </style>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12 col-sm-12">
      <div class="row">
        <div class="col-md-12 col-sm-12 form__responsive">
          <div class="row">
            <div class="col-md-8 col-sm-8">
              <label style="font-size: 19px;">รายงานการออกบิล</label>
            </div>
            <div class="col-md-4 col-sm-4" align="right">
              <div class="wlp_link">
                <a href="{{ route('open-bill.create') }}" style="text-decoration: none;"><i class="fas fa-chevron-circle-left" style="font-size: 14px;"></i>&nbsp;กลับหน้าออกบิล</a>
              </div>
            </div>
          </div>
          <hr>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <form action="{{ url('open-bill/create/report') }}" method="GET">
            <div class="row" style="margin-bottom: 18px;">
              <div class="col-md-12 col-sm-12">
                <div class="form-group">
                  <label class="col-md-2 col-sm-2" for="route" style="margin-top: 6px;">เลือกสาย :</label>
                  <div class="col-md-3 col-sm-4" style="padding-right: 2px; padding-left: 0px;">
                    {!! Form::select('route_id', $routes, $route_id, ['class' => 'form-control', 'id' => 'route', 'required' => '', 'placeholder' => 'เลือกรหัสสาย']) !!}
                  </div>
                  <div class="col-md-6 col-sm-4" style="margin: 0; padding: 0;">
                    <input id="route_description" type="text" class="form-control" readonly />
                  </div>
                  <div class="col-md-1 col-sm-2" align="left">
                    <button type="submit" class="btn btn-info"><i class="fas fa-search"></i></button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>

      @if(isset($customers))
        @foreach($customers as $customer)
          @if(!$customer -> get_bills -> isEmpty())
            <div class="row" style="margin-bottom: 5px;">
              <div class="col-md-12" align="right">
                <a href="{{ url('open-bill-report?route_id=' . $route_id) }}" target="_blank" style="text-decoration: none;"><i class="fas fa-print"></i>&nbsp;&nbsp;พิมพ์หน้านี้</a>
              </div>
            </div>
            @break
          @endif
        @endforeach
      @endif

      <table id="example" class="display">
        <thead>
          <tr>
            <th width="13%">ลำดับส่ง</th>
            <th width="7%">สาย</th>
            <th width="15%">รหัสลูกค้า</th>
            <th>ชื่อลูกค้า</th>
            <th width="15%">จำนวนบิล</th>
            <th width="6%">&nbsp;</th>
          </tr>
        </thead>
        <tbody>
          @if(isset($customers))
            @foreach($customers as $customer_group)
              @foreach($customer_group -> get_customer_group as $rec)
                <tr>
                  <td>{{ $customer_group -> cus_route_order }}</td>
                  <td>{{ $rec -> get_customer_route -> get_route -> route_code }}</td>
                  <td>{{ $rec -> get_customer -> cus_code }}</td>
                  <td>{{ $rec -> get_customer -> cus_name }}</td>
                  <td>{{ $customer_group -> get_bills -> count() }}</td>
                  <td><a href="#" data-toggle="modal" data-target="#viewModal{{ $customer_group -> cus_id }}"><i class="fas fa-search" style="font-size: 13px;"></i></a></td>
                </tr>
              @endforeach
            @endforeach
          @else
            <tr>
              <td colspan="6" style="text-align: center;">เลือกรายการจากด้านบน</td>
            </tr>
          @endif
        <tbody>
      </table>

      <!-- Modal -->
      @if(isset($customers))
        @foreach ($customers as $customer_modal)
          <div id="viewModal{{ $customer_modal -> cus_id }}" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h5 class="modal-title" style="font-weight: bold;">ลูกค้า&nbsp;&nbsp;:&nbsp;&nbsp;{{ $customer_modal -> get_customer -> cus_code . " - " . $customer_modal -> get_customer -> cus_name }}</h5>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-md-12">
                      <table class="custom_table">
                        <tr>
                          <th width="10%">ลำดับส่ง</th>
                          <th width="7%">สาย</th>
                          <th width="11%">รหัสลูกค้า</th>
                          <th>ชื่อลูกค้า</th>
                          <th>เลขที่บิล</th>
                          <th width="15%">เวลาออกบิล</th>
                        </tr>
                        @foreach($customer_modal -> get_bills as $row)
                          <tr>
                            <td>{{ $customer_modal -> cus_route_order }}</td>
                            <td>{{ $row -> get_customer_route -> get_route -> route_code }}</td>
                            <td>{{ $row -> get_customer -> cus_code }}</td>
                            <td>{{ $row -> get_customer -> cus_name }}</td>
                            <td>{{ $row -> bill_code }}</td>
                            <td>{{ $row -> time_to_start -> format('H:i:s') . " น." }}</td>
                          </tr>
                        @endforeach
                      </table>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      @endif
      <!-- End Modal -->

    </div>
  </div>
@endsection

@section('script')
  <script>
    $(document).ready(function() {
      let route_id = $('#route').val();
      if(route_id == '' || route_id == null) {
        $('#route_description').val('');
      } else {
        request_function(route_id);
      }
    });
    $(document).on('change', '#route', function() {
      let route_id = $(this).val();
      if(route_id == '' || route_id == null) {
        $('#route_description').val('');
      } else {
        request_function(route_id);
      }
    });

    const request_function = (param) => {
      $.ajax({
        url: '/ajax/request-from-route',
        type: 'GET',
        dataType: 'JSON',
        data: {route_id: param},
        success: function(response) {
          let route_data = response[0];
          $('#route_description').val(route_data.route_description);
        },
        error: function(response) {
          console.log('ไม่สามารถติดต่อ server ได้');
        }
      });
    }
  </script>
@endsection
