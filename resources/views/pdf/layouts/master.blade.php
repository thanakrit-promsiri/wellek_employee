<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
  </head>

  @yield('stylesheet')

  <style>
    @font-face {
      font-family: 'THSarabunNew';
      font-style: normal;
      font-weight: normal;
      src: url("{{ public_path('font/THSarabun/THSarabunNew.ttf') }}") format('truetype');
    }
    @font-face {
      font-family: 'THSarabunNew';
      font-style: normal;
      font-weight: bold;
      src: url("{{ public_path('font/THSarabun/THSarabunNew Bold.ttf') }}") format('truetype');
    }
    @font-face {
      font-family: 'THSarabunNew';
      font-style: italic;
      font-weight: normal;
      src: url("{{ public_path('font/THSarabun/THSarabunNew Italic.ttf') }}") format('truetype');
    }
    @font-face {
      font-family: 'THSarabunNew';
      font-style: italic;
      font-weight: bold;
      src: url("{{ public_path('font/THSarabun/THSarabunNew BoldItalic.ttf') }}") format('truetype');
    }
    body {
      font-family: "THSarabunNew";
    }
    table {
      border-collapse: collapse;
    }
    th {
      border: 1px solid;
    }
  </style>

  <body>
    @yield('content')
  </body>

</html>
