<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Monada Web') }}</title>
    <!-- Styles -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
</head>
<body>
   <div class="pd-5 container "><h1>Aplicação spa base</h1></div>
   <div id="app">
   </div>

   <!-- Scripts -->
   <script>
      window.Laravel = <?php echo json_encode([
         'csrfToken' => csrf_token()
      ]); ?>
   </script>  
   <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
