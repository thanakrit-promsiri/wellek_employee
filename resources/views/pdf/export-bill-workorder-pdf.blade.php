@extends('pdf.layouts.master')

@section('title', 'ใบสั่งงาน')

@section('stylesheet')
  <style>
    table {
      width: 100%;
      border: 1px solid black;
    }
    th {
      text-align: center;
      align-items: center;
      font-weight: bold;
      font-size: 20px;
      background-color: #F3F3F3;
    }
    td {
      text-align: center;
      align-items: center;
      font-size: 18px;
      padding-bottom: 4px;
      border: 1px solid black;
    }
    /* br{
        margin: 1rem 0;
        display: block;
    } */
  </style>
@endsection

@section('content')
  <div style="margin-bottom: 20px; text-align: center;">
    <label style="font-size: 26px; font-weight: bold;">ใบสั่งงาน</label>
    {{-- <span style="font-size: 20px; font-weight: normal;">ณ วันที่ : {{ $time_now }}</span> --}}
  </div>
  <label style="font-size:16pt">
    {{-- <b>ร้านวัฒนเวช ระยอง</b><br>
    ที่อยู่ 72 หมู่ 1 ตำบลกร่ำ อำเภอแกลง จังหวัดระยอง รหัสไปรษณีย์ 21190<br><br> --}}
    {{-- <b>เลขประจำตัวผู้เสียภาษี</b>&nbsp;&nbsp;&nbsp;1212318541325<br> --}}
    <b>สาย</b> {{$route -> route_code}} : {{$route -> route_description}}<br>
    <b>ชื่อพนักงานขับรถ :</b>&nbsp;&nbsp;&nbsp;............................................. &nbsp;&nbsp;&nbsp;<b>ทะเบียน :</b>&nbsp;&nbsp;&nbsp;.............................................
  </label><br>
  <label style="font-size:16pt;margin-left:65%;margin-top:-50%">
    วันที่ : {{ $time_now }}<br>
  </label><br>
  <table>
    <tr>
      <th width="8%">ลำดับสาย</th>
      <th width="10%">รหัสลูกค้า</th>
      <th width="15%">เลขที่ใบวางบิล</th>
      <th width="10%">จำนวนเงิน</th>
      <th width="10%">ลายเซ็นลูกค้า</th>
      <th width="10%">ผู้ตรวจสอบ</th>
      <th width="15%">หมายเหตุ</th>
    </tr>
    @if(isset($customers))
    @foreach($customers as $customer)
        @foreach($customer -> get_bills_for_export_bill as $row)
            @if( $row -> get_final_bill -> status == 2 )
                <tr>
                    <td>{{ $customer -> cus_route_order }}</td>
                    <td>{{ $row -> get_customer -> cus_code }}</td>
                    <td>{{ $row -> get_final_bill -> final_bill_code }}</td>
                    <td>{{ number_format($row -> get_final_bill -> final_bill_cost) }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endif
        @endforeach
    @endforeach
    @endif
  </table>
    @if(isset($cost))
    @foreach($cost as $cost)
            <label style="font-size:16pt;position: absolute;right: 0px;">ยอดเงินรวม {{ number_format($cost ->  total) }} บาท</label><br>
    @endforeach
    @endif

  {{-- <table width="100%">
    <tr>
      <td width="50%" align="left"></td>
      <td width="50%" align="right">สินค้าในระบบทั้งสิ้น :&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight: bold;">{{ $qty_count }}</span>&nbsp;&nbsp;&nbsp;&nbsp;ชิ้น</td>
    </tr>
  </table> --}}
@endsection
