@extends('pdf.layouts.master')

@section('title', 'พิมพ์สติ๊กเกอร์')

@section('stylesheet')
  <style>
    .left {
        text-align:left; display:inline-block;
    }
    .right {
        text-align:right; display:inline-block;
    }
    #north    { border : 0px solid black; margin:0;  padding:1em;  }
    /* #south    { border : 0px solid black;margin:0;  padding:1em;  }
    #east     { border : 1px solid black;margin:0;  padding:1em;  width:10cm; height:10cm; float:left; margin-right:1.1em } */
    #west     { border : 1px solid black;margin:0;  padding:1em;  width:5cm; height:10cm; float:right }
    #center   { border : 1px solid black;margin:0;  padding:1em;  padding-bottom:0em; height:10cm;}
    /* #center:after    { content:' '; clear:both; display:block; height:0; overflow:hidden } */
  </style>
@endsection

@section('content')
  <?php use Carbon\Carbon; ?>
  {{-- <div style="margin-bottom: 20px; text-align: center;">
    <label style="font-size: 22px; font-weight: bold;">พิมพ์ป้าย</label><br>
    <span style="font-size: 22px; font-weight: normal;">ณ วันที่ : {{ FullFormatDateThai(date('Y-m-d H:i:s', strtotime(\Carbon\Carbon::now() -> toDateString()))) }}</span>
  </div> --}}

  {{-- <br /> --}}
   @foreach ($bill_details_qc as $value)
    <?php $i = 1; ?>
    @for($i == 1; $i <= $value -> total; $i++)
    <p style="font-size:14pt">ร้านวัฒนเวช ระยอง</p>
    <div style="border : 1px solid black;width:7.5cm;height:7.5cm">
        <div style="margin-top:0cm">
            <span style="font-size:14pt;margin-left:5px"> ผู้รับสินค้า </span><br/>
            <span style="font-size:14pt;margin-left:5px">{{$value -> get_customer -> cus_name}}</span><br/>
            <span style="font-size:14pt;margin-left:5px">{{$value -> get_customer -> cus_address}}</span><br/>
            <span style="font-size:14pt;margin-left:5px">{{$value -> get_customer -> cus_phone1}}</span><br/><br/>
            <span style="font-size:14pt;margin-left:5px">หมายเหตุ</span><br/>
            @if($value -> bill_description == null)
                <span style="font-size:14pt;margin-left:5px">ไม่มีหมายเหตุ</span><br/>
            @else
                <span style="font-size:14pt;margin-left:5px"> {{$value -> bill_description}}</span><br/>
            @endif
        </div>
    </div>
    <center>
    <div style="margin-top:-7.555cm;margin-left:7.53cm;border : 1px solid black;width:2.5cm;height:1.45cm">
        <span style="font-size:12pt;font-weight: bold;">
            เลขที่บิล<br>
            {{$value -> bill_code}}
        </span>
    </div>
    <div style="margin-top:-0.02cm;margin-left:7.53cm;border : 1px solid black;width:2.5cm;height:1.45cm">
        <span style="font-size:12pt;font-weight: bold;">
            สายส่ง<br>
            {{$value -> get_customer_route -> get_route -> route_code}}
        </span>
    </div>
    <div style="margin-top:-0.02cm;margin-left:7.53cm;border : 1px solid black;width:2.5cm;height:1.45cm">
        <span style="font-size:12pt;font-weight: bold;">
            รหัสลูกค้า<br>
            {{$value -> get_customer -> cus_code}}
        </span>
    </div>
    <div style="margin-top:-0.02cm;margin-left:7.53cm;border : 1px solid black;width:2.5cm;height:1.45cm">
        <span style="font-size:12pt;font-weight: bold;">
            จำนวนกล่องตามบิล<br>
            {{$value -> total}}
        </span>
    </div>
    <div style="margin-top:-0.02cm;margin-left:7.53cm;border : 1px solid black;width:2.5cm;height:1.568cm">
        <span style="font-size:12pt;font-weight: bold;">
            ลำดับกล่องที่<br>
            {{$i}}/{{$value -> total}}
        </span>
    </div>
    </center>
    {{-- <p style="margin-top:15em"></p> --}}
     @endfor
    @endforeach
@endsection
