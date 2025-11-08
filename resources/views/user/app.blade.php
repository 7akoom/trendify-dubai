<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Trendify | Dashboard</title>

  <link rel="stylesheet" href="{{ asset('assets/back/css/nucleo-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/back/css/nucleo-svg.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/back/css/soft-ui-dashboard.css?v=1.0.3') }}">
  <link rel="stylesheet" href="{{ asset('assets/back/css/style.css?v=1.0.3') }}">
  <link rel="icon" href="{{ asset('assets/back/img/favicon.png') }}" type="image/png">
  <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
  <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">

  <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
  <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
  <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>

  <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
  
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
</head>

<body class="g-sidenav-show rtl bg-gray-100">
  @include('user.aside')

  <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg overflow-hidden">
    @include('admin.partials.nav')

    <div id="ajax-container">
      @yield('content')
    </div>

    @include('admin.partials.footer')
  </main>

  <script src="{{ asset('assets/back/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('assets/back/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/back/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/back/js/plugins/smooth-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/back/js/soft-ui-dashboard.min.js?v=1.0.3') }}"></script>

  @include('admin.partials.scripts')
  @yield('scripts')

</body>
</html>
