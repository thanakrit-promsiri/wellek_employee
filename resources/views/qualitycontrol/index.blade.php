@extends('layouts.master')

@section('title', 'รายการรอตรวจสอบ')

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
          <label style="font-size: 19px;">รายการรอตรวจสอบ<span>&nbsp;&nbsp;{{$bill_details_wait_to_qc_count}}&nbsp;&nbsp;</span>รายการ</label>
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
                    <td>{{ FullFormatDateThai(date('Y-m-d H:i:s', strtotime($row_bill_details -> time_to_start))) }}</td>
                    <td>{{ $row_bill_details -> get_customer_route -> get_route -> route_code }}</td>
                    <td>{{ $row_bill_details -> get_customer -> cus_code }}</td>
                    <td>{{ $row_bill_details -> get_customer -> cus_name }}</td>
                    <td>{{ $row_bill_details -> bill_code }}</td>
                    {{-- <td><a href="#" class="zoom_bill" id="{{ $row_bill_details -> cus_id }}"><i class="fas fa-plus" style="font-size: 17px;"></i></a></td> --}}
                    <td align="center"><a href="#" data-toggle="modal" data-target="#ModalChecking{{$row_bill_details -> id}}"><i class="fas fa-search" style="font-size: 17px;"></i></a></td>
                </tr>
                {{-- <tbody id="show-data{{$row_bill_details -> get_customer -> cus_code}}">
                    <div id="show-modal"></div>
                </tbody> --}}

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
                            {!! Form::model($row_bill_details, ['method' => 'PATCH', 'route' => ['quality-control.update', $row_bill_details -> id]]) !!}
                              <div class="col-md-12 form-margin" align="right">
                                <div class="form-group">
                                  <div class="col-sm-12">
                                      <button type="submit" class="btn btn-success" style="margin-top: 12px"><i class="fas fa-clipboard-check"></i>&nbsp;&nbsp;ยืนยันการตรวจสอบ</button>
                                  </div>
                                </div>
                              </div>
                            {!! Form::close() !!}
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
                                            @if(!empty($row_bill_details -> get_reject -> reject_description))
                                                <textarea class="form-control reject_description" name="reject_description{{ $row_bill_details -> id }}" data-testval="{{ $row_bill_details -> id }}" rows="2">{{ $row_bill_details -> get_reject -> reject_description }}</textarea>
                                            @else
                                                <textarea class="form-control reject_description" name="reject_description{{ $row_bill_details -> id }}" data-testval="{{ $row_bill_details -> id }}" rows="2"></textarea>
                                            @endif
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
        </tbody>
      </table>
    </div>
  </div>
@endsection
@section('script')
<script>
    // disabled check submit button
    $(document).on('keyup', '.reject_description', function() {
      var id = $(this).data('testval');
      var note = $(this).val();
      console.log(id, note);
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

    // $('.packer_id').keyup(function(event) {
    //     let bill_id = this.id;
    //     let packer_id = $('#'+bill_id).val();
    //     $('#alert_packer_id'+bill_id).hide();
    //     if(packer_id != '' && packer_id != null) {
    //         $.ajax({
    //             url: '/ajax/validate-packer-id',
    //             type: 'GET',
    //             dataType: 'JSON',
    //             data: {packer_id: packer_id},
    //             success: function(response) {
    //               if(response === 'fail') {
    //                   $('#submit_modal'+bill_id).attr('disabled', '');
    //                   $('#alert_packer_id'+bill_id).html('ไม่มีข้อมูลพนักงานเช็คสินค้า');
    //                   $('#alert_packer_id'+bill_id).show();
    //               }else {
    //                   $('#submit_modal'+bill_id).removeAttr('disabled');
    //                   $('#alert_packer_id'+bill_id).html('คุณ' + response.emp_firstname + ' ' + response.emp_lastname);
    //                   $('#alert_packer_id'+bill_id).show();
    //               }
    //             },
    //             error: function(response) {
    //               console.log('ไม่สามารถติดต่อ server ได้');
    //             }
    //         });
    //     } else {
    //       $('#submit_modal'+bill_id).attr('disabled', '');
    //       $('#alert_packer_id'+bill_id).html('กรุณากรอกรหัสผู้แพ็ค...');
    //       $('#alert_packer_id'+bill_id).show();
    //     }
    // });

    // $('.zoom_bill').click(function(){
    //     var cus_id = this.id;
    //     // alert(cus_id);
    //     $.ajax({
    //         url: '/ajax/request-bill-detail-zoom?cus_id='+cus_id,
    //         type: 'POST',
    //         dataType: 'JSON',
    //         success: function(response) {
    //             var html = '';
    //             var html_modal = '';
    //             var html_back = '';
    //             for(var i = 0; i < response.length; i++){
    //                 var data = response[i];
    //                 var id  = data.id;
    //                 var time_to_start  = data.time_to_start;

    //                 var date = new Date(time_to_start);
    //                 var dd = date.getDate();
    //                 var mm = date.getMonth() + 1; //January is 0!
    //                 var yyyy = date.getFullYear();

    //                 if(mm < 10) { mm = '0' + mm }

    //                 var thmonth = new Array ("", "ม.ค.", "ก.พ.", "มี.ค.",
    //                 "เม.ย.", "พ.ค", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.",
    //                 "ต.ค.", "พ.ย.", "ธ.ค.");

    //                 date = dd + ' ' + thmonth[mm] + ' ' + (yyyy + 543);

    //                 var time = moment(time_to_start).format('LTS');
    //                 var cus_code  = data.get_customer.cus_code;
    //                 var cus_name  = data.get_customer.cus_name;
    //                 var route_code  = data.get_customer_route.get_route.route_code;
    //                 var bill_code = data.bill_code;
    //                 html += '<tr>';
    //                     html += '<td>'+(i+1)+'</td>';
    //                     html += '<td>'+date+'&nbsp;'+time+' น.</td>';
    //                     html += '<td>'+route_code+'</td>';
    //                     html += '<td>'+cus_code+'</td>';
    //                     html += '<td>'+cus_name+'</td>';
    //                     html += '<td>'+bill_code+'</td>';
    //                     html += '<td align="center"><a href="#" data-toggle="modal" data-target="#ModalChecking'+id+'"><i class="fas fa-search" style="font-size: 17px;"></i></a></td>';
    //                 html += '</tr>';

    //                 document.getElementById("show-data"+cus_code).innerHTML = html;

    //                 html_modal += '<div class="modal fade" id="ModalChecking'+id+'" role="dialog">';
    //                     html_modal += '<div class="modal-dialog modal-lg">';
    //                         html_modal += '<div class="modal-content">';
    //                             html_modal += '<div class="modal-header">';
    //                                 html_modal += '<button type="button" class="close" data-dismiss="modal">&times;</button>';
    //                                 html_modal += '<h4 class="modal-title text-center" style="font-weight: bold;">รายละเอียดข้อมูล</h4>';
    //                             html_modal += '</div>';
    //                             html_modal += '<div class="modal-body">';
    //                                     html_modal += '<div class="row">';
    //                                         html_modal += '<div class="col-md-12">';
    //                                             html_modal += '<span class="pull-left">วันที่เปิดบิล&nbsp; '+date+' &nbsp;</span>';
    //                                             html_modal += '<span class="pull-right">เวลาที่เปิดบิล&nbsp; '+time+' น. &nbsp;</span>';
    //                                         html_modal += '</div>';
    //                                     html_modal += '</div>';
    //                                     html_modal += '<div class="wrapper_modal">';
    //                                             html_modal += '<div class="row">';
    //                                                 html_modal += '<div class="form-group" style="margin-top:15px">';
    //                                                     html_modal += '<label for="road" class="control-label col-sm-2">สาย : </label>';
    //                                                     html_modal += '<div class="col-sm-10">';
    //                                                         html_modal += '<input type="text" class="form-control" id="road" value="'+route_code+'" readonly>';
    //                                                     html_modal += '</div>';
    //                                                 html_modal += '</div>';
    //                                             html_modal += '</div>';
    //                                             html_modal += '<br>';
    //                                             html_modal += '<div class="row">';
    //                                                 html_modal += '<div class="form-group">';
    //                                                     html_modal += '<label for="bill_number" class="control-label col-sm-2">เลขที่บิล : </label>';
    //                                                     html_modal += '<div class="col-sm-10">';
    //                                                         html_modal += '<input type="text" class="form-control" id="bill_number" value="'+bill_code+'" readonly>';
    //                                                     html_modal += '</div>';
    //                                                 html_modal += '</div>';
    //                                             html_modal += '</div>';
    //                                             html_modal += '<br>';
    //                                             html_modal += '<div class="row">';
    //                                                 html_modal += '<div class="col-sm-6">';
    //                                                     html_modal += '<div class="form-group">';
    //                                                         html_modal += '<label for="customer_number" class="control-label col-sm-3">รหัสลูกค้า : </label>';
    //                                                         html_modal += '<div class="col-sm-9">';
    //                                                             html_modal += '<input type="text" class="form-control" id="customer_number" value="'+cus_code+'" readonly>';
    //                                                         html_modal += '</div>';
    //                                                     html_modal += '</div>';
    //                                                 html_modal += '</div>';
    //                                                 html_modal += '<div class="col-sm-6">';
    //                                                     html_modal += '<div class="form-group">';
    //                                                         html_modal += '<label for="customer_name" class="control-label col-sm-3">ชื่อลูกค้า : </label>';
    //                                                         html_modal += '<div class="col-sm-9">';
    //                                                             html_modal += '<input type="text" class="form-control" id="customer_name" value="'+cus_name+'" readonly>';
    //                                                         html_modal += '</div>';
    //                                                     html_modal += '</div>';
    //                                                 html_modal += '</div>';
    //                                             html_modal += '</div>';
    //                                             html_modal += '<hr>';
    //                                     html_modal += '<form id="frmMain" name="frmMain">';
    //                                             html_modal += '<div class="row">';
    //                                                 html_modal += '<div class="form-group">';
    //                                                     html_modal += '<label for="packer_id" class="control-label col-sm-2">รหัส Packer : </label>';
    //                                                     html_modal += '<div class="col-sm-10">';
    //                                                         html_modal += '<input type="text" class="form-control packer_id" id="'+id+'" name="packer_id'+id+'" onkeyup="this.value=this.value.toUpperCase();" required>';
    //                                                         html_modal += '<div style="margin-top:10px"></div>';
    //                                                         html_modal += '<div id="alert_packer_id'+id+'"></div>';
    //                                                     html_modal += '</div>';
    //                                                 html_modal += '</div>';
    //                                             html_modal += '</div>';
    //                                             // html_modal += '<br>';
    //                                             // html_modal += '<div class="row">';
    //                                             //     html_modal += '<div class="col-sm-6">';
    //                                             //         html_modal += '<div class="form-group">';
    //                                             //             html_modal += '<label for="total" class="control-label col-sm-3">จำนวน : </label>';
    //                                             //             html_modal += '<div class="col-sm-9">';
    //                                             //                 html_modal += '<input type="text" class="form-control" id="total" name="total" required>';
    //                                             //             html_modal += '</div>';
    //                                             //         html_modal += '</div>';
    //                                             //     html_modal += '</div>';
    //                                             //     html_modal += '<div class="col-sm-6">';
    //                                             //         html_modal += '<div class="form-group">';
    //                                             //             html_modal += '<label for="total_parlate" class="control-label col-sm-3">พาเลท : </label>';
    //                                             //             html_modal += '<div class="col-sm-9">';
    //                                             //                 html_modal += '<input type="text" class="form-control" id="total_parlate" name="total_parlate" required>';
    //                                             //             html_modal += '</div>';
    //                                             //         html_modal += '</div>';
    //                                             //     html_modal += '</div>';
    //                                             // html_modal += '</div>';
    //                                         html_modal += '</div>';
    //                                     html_modal += '</div>';
    //                                     html_modal += '<div class="modal-footer">';
    //                                         html_modal += '<center><a href="#" id="'+id+'" class="btn btn-success submit"><i class="fas fa-clipboard-check"></i>&nbsp;&nbsp;ตรวจสอบข้อมูลเรียบร้อย</a></center>';
    //                                     html_modal += '</div>';
    //                                     html_modal += '</form>';
    //                         html_modal += '</div>';
    //                     html_modal += '</div>';
    //                 html_modal += '</div>';

    //                 document.getElementById("show-modal").innerHTML = html_modal;
    //                 // console.log(document.getElementById("show-modal").innerHTML = html_modal);

    //             }

    //             // html_back += '<div class="wlp_link">';
    //             //         html_back += '<a href="/quality-control" style="text-decoration: none;"><i class="fas fa-chevron-circle-left" style="font-size: 17px;"></i>&nbsp;กลับหน้ารายการรอ QC</a>';
    //             // html_back += '</div>';
    //             // document.getElementById("show-back").innerHTML = html_back;

    //             $(".submit").click(function(e){
    //                 e.preventDefault();
    //                 var bill_id = this.id;
    //                 var packer_id = $('input[name=packer_id'+bill_id+']').val();

    //                 $.ajax({
    //                     url: '/ajax/request-bill-detail-edit-qc?bill_id='+bill_id+'&packer_id=' + packer_id,
    //                     type: 'POST',
    //                     dataType: 'JSON',
    //                     success: function(response) {
    //                         console.log(response);
    //                     },
    //                     error: function(response) {
    //                         console.log('ไม่สามารถติดต่อ server ได้');
    //                     }
    //                 });
    //             });
    //         },
    //         error: function(response) {
    //         console.log('ไม่สามารถติดต่อ server ได้');
    //         }
    //     });
    // });
</script>
@endsection
