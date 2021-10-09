@extends('layouts.master')

@section('title', 'แก้ไขบิล')

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
        {!! Form::open(['method' => 'PATCH', 'route' => ['open-bill.update', $customer_route -> cus_id]]) !!}
          <table class="custom_table">
            <tr>
              <th width="8%">&nbsp;</th>
              <th>เลขที่บิล</th>
              <th width="18%">เวลาส่ง</th>
              <th width="18%">เวลาออกบิล</th>
              <th width="11%">หมายเหตุ</th>
            </tr>
            @php($no = 1)
            @foreach($bill_details as $row)
              <tr>
                <td><input type="checkbox" class="edit_bill" id="{{ $row -> id }}" data-description="{{ $row -> bill_description }}" name="bill_res[]" value="{{ $row -> id }}"></td>
                <td><input type="text" class="form-control only_eng_and_num" id="bill_code_{{ $row -> id }}" name="bill_code_{{ $row -> id }}" value="{{ $row -> bill_code }}" onkeyup="this.value=this.value.toUpperCase();" required readonly></td>
                <td><input type="date" class="form-control" id="bill_date_{{ $row -> id }}" name="date_bill_{{ $row -> id }}" value="{{ date('Y-m-d', strtotime($row -> time_to_send)) }}" required readonly /></td>
                <td>{{ $row -> time_to_start -> format('H:i:s') . " น." }}</td>
                <td>
                  @if(!empty($row -> bill_description))
                    <a data-toggle="modal" data-target="#modalDescription{{ $row -> id }}" style="text-decoration: none; cursor: pointer;">
                      <div id="description_td_change_{{ $row -> id }}"><i class="fas fa-clipboard-list"></i></div>
                    </a>
                  @else
                    <a data-toggle="modal" data-target="#modalDescription{{ $row -> id }}" style="text-decoration: none; cursor: pointer;">
                      <div id="description_td_change_{{ $row -> id }}">-</div>
                    </a>
                    {{-- รอแก้ไขใหม่ --}}
                  @endif
                </td>
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
                            <input type="text" class="form-control" id="description_bill_{{ $row -> id }}" name="description_bill_{{ $row -> id }}" value="{{ $row -> bill_description }}" placeholder="-" readonly />
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
              </tr>
            @endforeach
          </table>
          <div class="row" style="margin-top: 25px;">
            <div class="col-md-12" align="center">
              <a href="{{ url('open-bill/create/insert?customer_id=' . $customer_route -> cus_id) }}" class="btn btn-default" style="background-color: #DEDEDE;"><i class="fas fa-chevron-circle-left" style="font-size: 14px;"></i>&nbsp;&nbsp;กลับ</a>
              <button class="btn btn-warning" id="edit_status_btn" disabled><i class="fas fa-check-circle"></i>&nbsp;&nbsp;แก้ไขเสร็จสิ้น</button>
            </div>
          </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script>
    var edit_status_btn = 0;
    $('.edit_bill').change(function() {
      let bill_id = this.id;
      let bill_description = $(this).data("description");
      if($(this).is(":checked")) {
        edit_status_btn = edit_status_btn + 1;
        $('#bill_code_' + bill_id).removeAttr("readonly");
        $('#bill_date_' + bill_id).removeAttr('readonly');
        $('#description_bill_' + bill_id).removeAttr('readonly');
        $('#description_td_change_' + bill_id).html('แก้ไข');
        validateStatus();
      }
      else {
        edit_status_btn = edit_status_btn - 1;
        $('#bill_code_' + bill_id).attr('readonly', '');
        $('#bill_date_' + bill_id).attr('readonly', '');
        $('#description_bill_' + bill_id).attr('readonly', '');
        if(bill_description !== '' && bill_description !== null) {
          $('#description_td_change_' + bill_id).html('<i class="fas fa-clipboard-list"></i>');
        } else {
          $('#description_td_change_' + bill_id).html('-');
        }
        validateStatus();
      }
    });

    function validateStatus() {
      if(edit_status_btn > 0) {
        $('#edit_status_btn').removeAttr('disabled');
      } else {
        $('#edit_status_btn').attr('disabled', '');
      }
    }
</script>
@endsection
