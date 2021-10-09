@extends('layouts.master')

@section('title', 'พิมพ์ใบรายงาน')

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
  </style>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12 col-sm-12">
      <div class="row">
        <div class="col-md-12 col-sm-12 form__responsive">
          <label style="font-size: 19px;">รายการที่รอพิมพ์รายงาน</label>
          <hr>
        </div>
        {{-- <div class="col-md-3 col-sm-3" align="right">
          <div class="wlp_link">
            <a href="#" style="text-decoration: none;"><i class="fas fa-clipboard-list" style="font-size: 17px;"></i>&nbsp;ดูรายงาน</a>
          </div>
        </div> --}}
      </div>
      <div class="row">
        <div class="col-md-12">
            <table id="example" class="display">
                <thead>
                    <tr>
                        <th width="5%">สาย</th>
                        <th>ข้อมูลสาย</th>
                        <th>พิมพ์ใบเตรียมงาน</th>
                        <th>พิมพ์ใบสั่งงาน</th>
                    </tr>
                </thead>
                <tbody>
                    <div id="actors">
                        @foreach($route_details as $value)
                        <tr>
                            <td>{{$value -> route_code}}</td>
                            <td>{{$value -> route_description}}</td>
                            <td><a href="{{ url('export-bill-preparation?route_id='.$value -> id) }}" target="_blank" style="text-decoration: none;"><i class="fas fa-print" style="font-size: 17px;"></i>&nbsp;พิมพ์</a><br></td>
                            <td><a href="{{ url('export-bill-workorder?route_id='.$value -> id) }}" target="_blank" style="text-decoration: none;"><i class="fas fa-print" style="font-size: 17px;"></i>&nbsp;พิมพ์</a></td>
                        </tr>
                        @endforeach
                    </div>
                </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script>
    //
  </script>
@endsection
