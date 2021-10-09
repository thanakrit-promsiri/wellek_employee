<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>:: wlp-01 | เข้าสู่ระบบ ::</title>

    <!-- integrate css -->
    {{-- <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Kanit"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/customs-css.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-4.1.3/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('font/MaterialDesignIcon/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('font/fontawesome-5.4.1/css/all.min.css') }}">
    <!-- custom css -->
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        font-family: 'K2D', sans-serif;
      }
      .wrapper {
        position: relative;
        width: 100%;
        min-height: 60vh;
        top: 25%;
      }
      .centered {
        position: fixed;
        top: 50%;
        left: 50%;
        /* bring your own prefixes */
        transform: translate(-50%, -50%);
      }
      .clearfix:after {
        content: "";
        display: block;
        clear: both;
        visibility: hidden;
        height: 0;
      }
      .form_wrapper {
        background: #fff;
        width: 350px;
        max-width: 100%;
        box-sizing: border-box;
        padding: 25px;
        margin: auto;
        position: relative;
        z-index: 1;
        border-top: 5px solid #1D88FF;
        -webkit-box-shadow: 0 0 3px rgba(0, 0, 0, 0.1);
        -moz-box-shadow: 0 0 3px rgba(0, 0, 0, 0.1);
        box-shadow: 0 0 3px rgba(0, 0, 0, 0.1);
      }
      .form_wrapper h2 {
        font-size: 1.5em;
        line-height: 1.5em;
        margin: 0;
      }
      .form_wrapper .title_container {
        text-align: center;
        padding-bottom: 15px;
      }
      .form_wrapper h3 {
        font-size: 1.1em;
        font-weight: normal;
        line-height: 1.5em;
        margin: 0;
      }
      .form_wrapper .row {
        margin: 10px -15px;
      }
      .form_wrapper .row > div {
        padding: 0 15px;
        box-sizing: border-box;
      }
      .form_wrapper .col_half {
        width: 100%;
        float: left;
      }
      .form_wrapper .input_field {
        position: relative;
        margin-bottom: 20px;
      }
      .form_wrapper .input_field > span {
        position: absolute;
        /* left: 0;
        top: 0; */
        color: gray;
        height: 100%;
        border-right: 1px solid #ccc;
        text-align: center;
        width: 40px;
      }
      .form_wrapper .input_field > span > i {
        /* padding-top: 30px; */
        font-size: 25px;
      }
      .form_wrapper input[type="text"] {
        width: 100%;
        padding: 8px 10px 9px 55px;
        height: 40px;
        border: 1px solid #ccc;
        box-sizing: border-box;
        outline: none;
        -webkit-transition: all 0.30s ease-in-out;
        -moz-transition: all 0.30s ease-in-out;
        -ms-transition: all 0.30s ease-in-out;
        transition: all 0.30s ease-in-out;
      }
      .form_wrapper input[type="text"]:focus {
        -webkit-box-shadow: 0 0 2px 1px #79C0FF;
        -moz-box-shadow: 0 0 2px 1px #79C0FF;
        box-shadow: 0 0 2px 1px #79C0FF;
        border: 1px solid #79C0FF;
      }
      .form_wrapper input[type="email"] {
        width: 100%;
        padding: 8px 10px 9px 55px;
        height: 40px;
        border: 1px solid #ccc;
        box-sizing: border-box;
        outline: none;
        -webkit-transition: all 0.30s ease-in-out;
        -moz-transition: all 0.30s ease-in-out;
        -ms-transition: all 0.30s ease-in-out;
        transition: all 0.30s ease-in-out;
      }
      .form_wrapper input[type="email"]:focus {
        -webkit-box-shadow: 0 0 2px 1px #79C0FF;
        -moz-box-shadow: 0 0 2px 1px #79C0FF;
        box-shadow: 0 0 2px 1px #79C0FF;
        border: 1px solid #79C0FF;
      }
      .form_wrapper input[type="password"] {
        width: 100%;
        padding: 8px 10px 9px 55px;
        height: 40px;
        border: 1px solid #ccc;
        box-sizing: border-box;
        outline: none;
        -webkit-transition: all 0.30s ease-in-out;
        -moz-transition: all 0.30s ease-in-out;
        -ms-transition: all 0.30s ease-in-out;
        transition: all 0.30s ease-in-out;
      }
      .form_wrapper input[type="password"]:focus {
        -webkit-box-shadow: 0 0 2px 1px #79C0FF;
        -moz-box-shadow: 0 0 2px 1px #79C0FF;
        box-shadow: 0 0 2px 1px #79C0FF;
        border: 1px solid #79C0FF;
      }
      @media (max-width: 600px) {
        .form_wrapper .col_half {
          width: 100%;
          float: none;
        }
      }
    </style>
  </head>
  <body>
    <div class="wrapper">
      <div class="form_wrapper">
        @if(Session::has('fail'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><i class="fas fa-exclamation-triangle"></i></strong>&nbsp;&nbsp;{{ Session::get('fail') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @endif
        @if(Session::has('re_login'))
          <div class="alert alert-info alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong><i class="fas fa-exclamation-circle"></i></strong>&nbsp;&nbsp;{{ Session::get('re_login') }}
          </div>
        @endif
        <div class="form_container">
          <div class="title_container">
            <h2>ลงชื่อเข้าสู่ระบบ</h2>
          </div>
          <div class="row clearfix">
            <div class="col_half">
              <form action="{{ url('/checklogin') }}" method="POST">
              {{ csrf_field() }}
                <div class="input_field"><span><i class="mdi mdi-account" aria-hidden="true"></i></span>
                  <input type="text" class="form-control" name="user_code" value="{{ old('user_code') }}" placeholder="รหัสพนักงาน" onkeyup="this.value=this.value.toUpperCase();" required />
                </div>
                <div class="input_field"><span><i class="mdi mdi-lock" aria-hidden="true"></i></span>
                  <input type="password" class="form-control" name="user_password" placeholder="รหัสผ่าน" required />
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <button class="btn btn-primary" type="submit" style="width: 100%;"><i class="fas fa-sign-in-alt" style="font-size: 18px;"></i>&nbsp;เข้าสู่ระบบ</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- integrate javascript -->
    <script type="text/javascript" src="{{ asset('js/jquery-1.12.4/jquery-1.12.4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap-4.1.3/bootstrap.min.js') }}"></script>
    <!-- custom javascript -->
    <script>
      //
    </script>
  </body>
</html>
