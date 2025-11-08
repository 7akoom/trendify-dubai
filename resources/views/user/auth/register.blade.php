<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/back/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('assets/back/img/favicon.png') }}">
  <title>
    Trendify | Admin Login
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
      
                      {{-- <div class="text-center">
                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/lotus.webp"
                          style="width: 185px;" alt="logo">
                        <h4 class="mt-1 mb-5 pb-1">We are The Lotus Team</h4>
                      </div> --}}
      
                      <form action="{{ route('user.register.attempt') }}" method="POST">
                        @csrf
                      
                        <p>{{ __('messages.Register Title') }}</p>
                        <div class="form-outline mb-4">
                          <input type="text" name="name" id="form2Example11" class="form-control" value="{{ old('name') }}" />
                          <label class="form-label" for="form2Example11">{{ __('messages.Name') }}</label>
                          @error('name')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-outline mb-4">
                          <input type="email" name="email" id="form2Example11" class="form-control" value="{{ old('email') }}" />
                          <label class="form-label" for="form2Example11">{{ __('messages.Email') }}</label>
                            @error('email')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-outline mb-4">
                          <input type="text" name="phone" id="form2Example11" class="form-control" value="{{ old('phone') }}" />
                          <label class="form-label" for="form2Example11">{{ __('messages.Phone') }}</label>
                            @error('phone')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <input type="hidden" name="status" value="1">
                      
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
                      
                        <div class="text-center pt-1 mb-5 pb-1">
                          <button type="submit" class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3">
                            {{ __('messages.Sign up') }}
                          </button>
                        </div>
                      
                        <div class="d-flex align-items-center justify-content-center pb-4">
                          <p class="mb-0 me-2">{{ __('messages.Have account') }}</p>
                          <a href="{{ route('user.login') }}" class="btn btn-outline-danger">{{ __('messages.Signin') }}</a>
                        </div>
                      </form>
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