<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <script src="{{ asset('js/app.js') }}" defer></script>
   <link href="{{ asset('css/app.css') }}" rel="stylesheet">
   <title>Laravel</title>
</head>
    <body class="antialiased">
    <div class="container">
  <table class="table table-fixed">
    <thead>
      <tr>
        <th class="col-xs-3">Errors</th>
      </tr>
    </thead>
    <tbody>
     @foreach ($errors as $error)
        @foreach ($error as $value)
      <tr>
        <td class="col-xs-3">{{ $value }}</td>
      </tr>
        @endforeach
      @endforeach
    </tbody>
  </table>

  <table class="table table-fixed">
    <thead>
      <tr>
        <th class="col-xs-3">Apache</th>
      </tr>
    </thead>
    <tbody>
     @foreach ($apaches as $apache)
        @foreach ($apache as $value)
      <tr>
        <td class="col-xs-3">{{ $value }}</td>
      </tr>
        @endforeach
      @endforeach
    </tbody>
  </table>


  <table class="table table-fixed">
    <thead>
      <tr>
        <th class="col-xs-3">SQL</th>
      </tr>
    </thead>
    <tbody>
     @foreach ($sql as $data)
        @foreach ($data as $value)
      <tr>
        <td class="col-xs-3">{{ $value }}</td>
      </tr>
        @endforeach
      @endforeach
    </tbody>
  </table>
</div>
    </body>
</html>
