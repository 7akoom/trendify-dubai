<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/back/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('assets/back/img/favicon.png') }}">
  <title>
    Trendify | Reset Password
  </title>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <link id="pagestyle" href="{{ asset('assets/back/css/soft-ui-dashboard.css?v=1.0.3') }}" rel="stylesheet" />
  <link href="{{ asset('assets/front/css/login.css?v=1.0.3') }}" rel="stylesheet" />
</head>

<body class="">
  <main class="main-content  mt-0">
    <section class="h-100 gradient-form" style="background-color: #eee;">
        <div class="container py-5 h-100">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-10">
              <div class="card rounded-3 text-black">
                <div class="row g-0">
                  <div class="col-lg-6">
                    <div class="card-body p-md-5 mx-md-4">
                      @if (session('status'))
                          <div class="alert text-success">
                              {{ session('status') }}
                          </div>
                      @endif
                      @if (session('error'))
                          <div class="alert text-danger">
                              {{ session('error') }}
                          </div>
                      @endif
                        <form action="{{ route('password.update') }}" method="POST">
                            @csrf   
                            <p>{{ __('messages.New Password') }}</p>   
                                <input type="hidden" name="token" value="{{ $token }}">
                                <input type="hidden" name="email" value="{{ $email }}">                    
                            
                                <div class="form-outline mb-4">
                                    <input type="password" name="password" id="form2Example22" class="form-control" />
                                    <label class="form-label" for="form2Example22">{{ __('messages.Password') }}</label>
                                      @error('password')
                                          <div class="text-danger small">{{ $message }}</div>
                                      @enderror
                                  </div>
          
                                  <div class="form-outline mb-4">
                                    <input type="password" name="password_confirmation" id="form2Example23" class="form-control" />
                                    <label class="form-label" for="form2Example23">{{ __('messages.Password Confirmation') }}</label>
                                      @error('password_confirmation')
                                          <div class="text-danger small">{{ $message }}</div>
                                      @enderror
                                  </div>
                            <div class="text-center pt-1 mb-2 pb-1">
                                <button type="submit" class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3">
                                  {{ __('messages.Confirm') }}
                                </button>
                              </div>
                    </div>
                  </div>
                  <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                    <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                      <h4 class="mb-4 text-white">{{__('messages.Sign in title_1')}}</h4>
                      <p class="small mb-0">{{__('messages.Sign in title_2')}} {{__('messages.Sign in title_3')}}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
  </main>
  <footer class="footer py-5">
    <div class="container">
      <div class="row">
        <div class="col-8 mx-auto text-center mt-1">
          <p class="mb-0 text-secondary">
            Copyright © <script>
              document.write(new Date().getFullYear())
            </script>
            <a href="https://www.linkedin.com/in/hkmt-ali/" class="font-weight-bold" target="_blank">HKMT ALI</a>
          </p>
        </div>
      </div>
    </div>
  </footer>
</body>

</html>