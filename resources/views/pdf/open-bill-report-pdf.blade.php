@extends('pdf.layouts.master')

@section('title', 'รายงานการออกบิล')

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
  </style>
@endsection

@section('content')
  <div style="margin-bottom: 20px; text-align: center;">
    <label style="font-size: 26px; font-weight: bold;">รายงานการออกบิล</label><br>
    <span style="font-size: 20px; font-weight: normal;">ณ วันที่ : {{ $time_now }}</span>
  </div>
  <br />
  <table>
    <tr>
      <th width="8%">ลำดับส่ง</th>
      <th width="5%">สาย</th>
      <th width="10%">รหัสลูกค้า</th>
      <th>ชื่อลูกค้า</th>
      <th width="15%">เลขที่บิล</th>
      <th width="10%">เวลาออกบิล</th>
    </tr>
    @foreach($customers as $customer)
      @foreach($customer -> get_bills as $row)
        <tr>
          <td>{{ $customer -> cus_route_order }}</td>
          <td>{{ $row -> get_customer_route -> get_route -> route_code }}</td>
          <td>{{ $row -> get_customer -> cus_code }}</td>
          <td>{{ $row -> get_customer -> cus_name }}</td>
          <td>{{ $row -> bill_code }}</td>
          <td>{{ $row -> time_to_start -> format('H:i:s') . " น." }}</td>
        </tr>
      @endforeach
    @endforeach
  </table>

  {{-- <table width="100%">
    <tr>
      <td width="50%" align="left"></td>
      <td width="50%" align="right">สินค้าในระบบทั้งสิ้น :&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight: bold;">{{ $qty_count }}</span>&nbsp;&nbsp;&nbsp;&nbsp;ชิ้น</td>
    </tr>
  </table> --}}
@endsection
