@extends('layouts.master')

@section('title', 'รายการขึ้นสินค้า')

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
            <div class="col-md-12 col-sm-12">
              <label style="font-size: 19px;">รายการขึ้นสินค้า</label>
            </div>
          </div>
          <hr>
        </div>
      </div>

      {{-- <div class="row">
        <div class="col-md-12">
          <form action="{{ url('/transfer-to-container') }}" method="GET">
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
      </div> --}}

      <table id="example" class="display">
        <thead>
          <tr>
            <th width="2%">สาย</th>
            <th width="13%">ลำดับส่ง</th>
            <th>ชื่อลูกค้า</th>
            <th width="5%">จำนวน</th>
            <th width="12%">พาเลท</th>
            <th>เลขที่บิล</th>
            <th width="2%">&nbsp;</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($final_bills as $final_bill)
            <tr style="{{ $final_bill -> status == 3 ? "background-color: #C8FDD0;" : "background-color: #F0F0F0;" }}">
              <th colspan="7" style="font-weight: normal;">
                ใบวางบิลเลขที่ {{ $final_bill -> final_bill_code }}
                @if($final_bill -> status == 3)
                  &nbsp;<i class="fas fa-check-circle" style="color: #32B334;"></i>
                @endif
              </th>
            </tr>
            @foreach ($final_bill -> get_bill_details as $row)
              <tr style="{{ $row -> transfer_to_container == 1 ? "background-color: #F2FBF4;" : "" }}">
                <td>{{ $row -> get_customer_route -> get_route -> route_code }}</td>
                <td>{{ $row -> get_customer_route -> cus_route_order }}</td>
                <td>{{ $row -> get_customer -> cus_name }}</td>
                <td>{{ $row -> total }}</td>
                <td>{{ $row -> total_parlate }}</td>
                <td>{{ $row -> bill_code }}</td>
                <td><input type="checkbox" class="bill_check" name="" data-bill="{{ $row -> id }}" data-code="{{ $row -> bill_code }}" {{ $row -> transfer_to_container == 1 ? "checked disabled" : "" }} /></td>
              </tr>
            @endforeach
          @endforeach
        </tbody>
      </table>
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
    $(document).on('click', '.bill_check', function() {
      let bill_code = $(this).data("code");
      var al = confirm('ยืนยันเลขบิล '+bill_code+' ?');
      if(al == true) {
        let bill_id = $(this).data("bill");
        $.ajax({
          url: '/ajax/update-transfer-to-container',
          type: 'POST',
          dataType: 'JSON',
          data: {bill_id: bill_id},
          success: function(response) {
            if(response === 'success') {
              window.location.reload();
            }
          },
          error: function(response) {
            console.log('ไม่สามารถติดต่อ server ได้');
          }
        });
      } else {
        $(this).prop('checked', false);
      }
    });
  </script>
@endsection
