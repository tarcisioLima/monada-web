<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
   @include('site.includes.head')
</head>
<body>
    @yield('content')
   <!-- Scripts -->
   <script>
      window.Laravel = <?php echo json_encode([
         'csrfToken' => csrf_token()
      ]); ?>
   </script>  
   <script src="/js/app.js"></script>
</body>
</html>
