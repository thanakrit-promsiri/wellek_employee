@extends('layouts.master')

@section('title', 'ออกบิล')

@section('stylesheet')
  <style>
    /*  */
  </style>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12 col-sm-12 form__responsive">
      <div class="row">
        <div class="col-md-9 col-sm-9">
          <label style="font-size: 19px;">เปิดบิลใหม่</label>
        </div>
        <div class="col-md-3 col-sm-3" align="right">
          <div class="wlp_link">
            <a href="{{ url('open-bill/create/report') }}" style="text-decoration: none;"><i class="fas fa-clipboard-list" style="font-size: 17px;"></i>&nbsp;ดูรายงาน</a>
          </div>
        </div>
      </div>
      <hr>
      <form class="form-horizontal" action="{{ url('open-bill/create/insert') }}" method="GET" onsubmit="return validateFuc();">
        <div class="form-group">
          <label class="control-label col-sm-3" for="route">เลือกสาย :</label>
          <div id="route_content" class="col-sm-9">
            <input id="route_id" type="hidden" name="route_id" />
            <input id="autocomplete_route" class="form-control" />
            {{-- {!! Form::select('route_id', $routes, null, ['class' => 'form-control route_select', 'id' => 'route', 'required' => '', 'placeholder' => 'เลือกรหัสสาย']) !!} --}}
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-3" for="route_description">รายละเอียดสาย :</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="route_description" placeholder="-" name="" readonly>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-3" for="customer">รหัสลูกค้า :</label>
          <div id="customer_content" class="col-sm-9">
            <input id="customer_id" type="hidden" name="customer_id" />
            <input id="autocomplete_customer" class="form-control" />
            {{-- {!! Form::select('customer_id', $customers, null, ['class' => 'form-control customer_select', 'id' => 'customer', 'required' => '', 'placeholder' => 'เลือกรหัสลูกค้า']) !!} --}}
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-3" for="customer_name">รายละเอียดลูกค้า :</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="customer_name" placeholder="-" name="" readonly>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 col-sm-12" align="center" style="margin-top: 18px;">
            <a class="btn btn-default" style="background-color: #DEDEDE;" onclick="location.reload();"><i class="fas fa-sync-alt"></i>&nbsp;&nbsp;ล้างข้อมูล</a>
            <button type="submit" class="btn btn-success"><i class="fas fa-check-circle"></i>&nbsp;&nbsp;เปิดบิล</button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

@section('script')
  <script>
    // var select_status = 0;
    // $(document).on('change', '.route_select', function() {
    //   select_status = 1;
    //   let route_id = $(this).val();
    //   if(route_id != '' && route_id != null) {
    //     $('#customer').empty();
    //     $('#customer').removeAttr('disabled');
    //     $("#customer").append('<option value="">เลือกรหัสลูกค้า</option>');
    //     $.ajax({
    //       url: '/ajax/request-from-route',
    //       type: 'GET',
    //       dataType: 'JSON',
    //       data: {route_id: route_id},
    //       success: function(response) {
    //         let route_data = response[0];
    //         $('#route_description').val(route_data.route_description);
    //         let customer_data = response[1];
    //         if(customer_data.length == 0) {
    //           $('#customer').empty();
    //           $('#customer').attr('disabled', '');
    //           $("#customer").append('<option value="">ไม่มีข้อมูล</option>');
    //         } else {
    //           $.each(customer_data, function(key, data) {
    //             $("#customer").append('<option value="'+data.get_customer.id+'">'+data.get_customer.cus_code+'</option>');
    //           });
    //         }
    //       },
    //       error: function(response) {
    //         console.log('ไม่สามารถติดต่อ server ได้');
    //       }
    //     });
    //   } else {
    //     select_status = 0;
    //     clear_select();
    //   }
    // });
    // $(document).on('change', '.customer_select', function() {
    //   let customer_id = $(this).val();
    //   if(customer_id != '' && customer_id != null) {
    //     $.ajax({
    //       url: '/ajax/request-from-customer',
    //       type: 'GET',
    //       dataType: 'JSON',
    //       data: {customer_id: customer_id},
    //       success: function(response) {
    //         let customer_data = response[0];
    //         $('#customer_name').val(customer_data.cus_name);
    //         if(select_status == 0) {
    //           let route_data = response[1].get_route;
    //           $('#route').empty();
    //           $("#route").append('<option value="'+route_data.id+'">'+route_data.route_code+'</option>');
    //           $('#route_description').val(route_data.route_description);
    //         }
    //       },
    //       error: function(response) {
    //         console.log('ไม่สามารถติดต่อ server ได้');
    //       }
    //     });
    //   } else {
    //     select_status = 0;
    //     clear_select();
    //   }
    // });
    // const clear_select = () => {
    //   $('#route_content').html('{!! Form::select('route_id', $routes, null, ['class' => 'form-control route_select', 'id' => 'route', 'required' => '', 'placeholder' => 'เลือกรหัสสาย']) !!}');
    //   $('#route_description').val('');
    //   $('#customer_content').html('{!! Form::select('customer_id', $customers, null, ['class' => 'form-control customer_select', 'id' => 'customer', 'required' => '', 'placeholder' => 'เลือกรหัสลูกค้า']) !!}');
    //   $('#customer_name').val('');
    // }
    // const bill_confirm = () => {
    //   $.confirm({
    //     title: 'แจ้งเตือน !',
    //     content: 'ยืนยันการเปิดบิล ?',
    //     type: 'blue',
    //     animation: 'zoom',
    //     closeAnimation: 'zoom',
    //     closeIcon: true,
    //     buttons: {
    //       ok: {
    //         btnClass: 'btn-blue',
    //         text: 'ยืนยัน',
    //         keys: ['enter'],
    //         action: function() {
    //           return true;
    //         }
    //       },
    //       cancel: {
    //         btnClass: 'btn-default',
    //         text: 'ยกเลิก',
    //         keys: ['esc'],
    //         action: function() {
    //           return false;
    //         }
    //       }
    //     }
    //   });
    // }
    var form_status = 0;
    const validateFuc = () => {
      if(form_status == 0) {
        return false;
      } else {
        return true;
      }
    }

    const update_status = () => {
      let route_name = $('#route_description').val();
      let customer_name = $('#customer_name').val();
      if(route_name != '' && route_name != null && customer_name != '' && customer_name != null) {
        form_status = 1;
      }
    }

    var route_response;
    var customer_response;
    $(document).ready(function() {
      $.ajax({
        url: '/ajax/autocomplete-get-route',
        type: 'GET',
        dataType: 'JSON',
        success: function(response) {
          route_response = response;
          var route_data = {
            data: route_response,
            theme: "blue-light",
            getValue: "route_code",
            template: {
              type: "description",
              fields: {
                description: "route_description"
              }
            },
            list: {
              maxNumberOfElements: 8,
              match: {
                enabled: true
              },
              onKeyEnterEvent: function() {
                $('#autocomplete_customer').removeAttr('placeholder');
                $('#autocomplete_customer').removeAttr('readonly');
                let route_description_auto = $("#autocomplete_route").getSelectedItemData().route_description;
                let route_id_auto = $('#autocomplete_route').getSelectedItemData().id;
                $("#route_description").val(route_description_auto).trigger('change');
                $('#route_id').val(route_id_auto);
                update_status();
                get_new_route(route_id_auto);
              },
              onClickEvent: function() {
                $('#autocomplete_customer').removeAttr('placeholder');
                $('#autocomplete_customer').removeAttr('readonly');
                let route_description_auto = $("#autocomplete_route").getSelectedItemData().route_description;
                let route_id_auto = $('#autocomplete_route').getSelectedItemData().id;
                $("#route_description").val(route_description_auto).trigger('change');
                $('#route_id').val(route_id_auto);
                update_status();
                get_new_route(route_id_auto);
              }
            }
          };
          $("#autocomplete_route").easyAutocomplete(route_data);
        },
        error: function(response) {
          console.log('ไม่สามารถติดต่อ server ได้');
        }
      });
      $.ajax({
        url: '/ajax/autocomplete-get-customer',
        type: 'GET',
        dataType: 'JSON',
        success: function(response) {
          customer_response = response;
          var customer_data = {
            data: customer_response,
            theme: "blue-light",
            getValue: "cus_code",
            template: {
              type: "description",
              fields: {
                description: "cus_name"
              }
            },
            list: {
              maxNumberOfElements: 8,
              match: {
                enabled: true
              },
              onKeyEnterEvent: function() {
                let cus_name_auto = $("#autocomplete_customer").getSelectedItemData().cus_name;
                let cus_id_auto = $('#autocomplete_customer').getSelectedItemData().id;
                $("#customer_name").val(cus_name_auto).trigger('change');
                $('#customer_id').val(cus_id_auto);
                update_status();
                get_new_customer(cus_id_auto);
              },
              onClickEvent: function() {
                let cus_name_auto = $("#autocomplete_customer").getSelectedItemData().cus_name;
                let cus_id_auto = $('#autocomplete_customer').getSelectedItemData().id;
                $("#customer_name").val(cus_name_auto).trigger('change');
                $('#customer_id').val(cus_id_auto);
                update_status();
                get_new_customer(cus_id_auto);
              }
            }
          };
          $("#autocomplete_customer").easyAutocomplete(customer_data);
        },
        error: function(response) {
          console.log('ไม่สามารถติดต่อ server ได้');
        }
      });
    });
    function get_new_route(route_id) {
      $.ajax({
        url: '/ajax/autocomplete-get-new-route',
        type: 'GET',
        dataType: 'JSON',
        data: {route_id: route_id},
        success: function(response) {
          if(response.length > 0) {
            var customer_new_data = {
              data: response,
              theme: "blue-light",
              getValue: "cus_code",
              template: {
                type: "description",
                fields: {
                  description: "cus_name"
                }
              },
              list: {
                maxNumberOfElements: 8,
                match: {
                  enabled: true
                },
                onKeyEnterEvent: function() {
                  let cus_name_auto = $("#autocomplete_customer").getSelectedItemData().cus_name;
                  let cus_id_auto = $('#autocomplete_customer').getSelectedItemData().cus_id;
                  $("#customer_name").val(cus_name_auto).trigger('change');
                  $('#customer_id').val(cus_id_auto);
                  update_status();
                },
                onClickEvent: function() {
                  let cus_name_auto = $("#autocomplete_customer").getSelectedItemData().cus_name;
                  let cus_id_auto = $('#autocomplete_customer').getSelectedItemData().cus_id;
                  $("#customer_name").val(cus_name_auto).trigger('change');
                  $('#customer_id').val(cus_id_auto);
                  update_status();
                }
              }
            };
            $("#autocomplete_customer").easyAutocomplete(customer_new_data);
          } else {
            $('#autocomplete_customer').val('');
            $('#customer_name').val('');
            $('#autocomplete_customer').attr('placeholder', 'ไม่มีลูกค้าในสายนี้');
            $('#autocomplete_customer').attr('readonly', '');
            form_status = 0;
          }
        },
        error: function(response) {
          console.log('ไม่สามารถติดต่อ server ได้');
        }
      });
    }
    function get_new_customer(customer_id) {
      $.ajax({
        url: '/ajax/autocomplete-get-new-customer',
        type: 'GET',
        dataType: 'JSON',
        data: {customer_id: customer_id},
        success: function(response) {
          $('#autocomplete_route').val(response.route_code);
          $("#route_description").val(response.route_description).trigger('change');
          $('#route_id').val(response.route_id);
          form_status = 1;
        },
        error: function(response) {
          console.log('ไม่สามารถติดต่อ server ได้');
        }
      });
    }

    const clear_select = () => {
      $('#route_id').val('');
      $('#route_description').val('');
      $('#customer_id').val('');
      $('#customer_name').val('');
    }
  </script>
@endsection
