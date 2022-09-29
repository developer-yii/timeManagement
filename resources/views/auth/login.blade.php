@extends('layouts.login')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/page/login.css') }}" />
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xxl-4 col-lg-5">
            <div class="card">

                <!-- Logo -->
                <div class="card-header text-center bg-primary">
                    <a href="{{route('index')}}">
                        <span><img src="{{ asset('images/logo.png') }}" alt="" height="100"></span>
                    </a>
                </div>

                <div class="card-body p-4">
                    
                    <div class="text-center w-75 m-auto">
                        <h4 class="text-dark-50 text-center pb-0 fw-bold">Sign In</h4>
                        <p class="text-muted mb-4">Enter your email address and password to access admin panel.</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="emailaddress" class="form-label">Email address</label>
                            <input class="form-control @error('email') is-invalid @enderror" name="email" type="email" id="emailaddress" required="" placeholder="Enter your email" value="{{ old('email') }}">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-muted float-end"><small>Forgot your password?</small></a>
                            @endif
                            
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter your password">
                                <div class="input-group-text" data-password="false">
                                    <span class="password-eye"></span>
                                </div>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3 mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkbox-signin" checked>
                                <label class="form-check-label" for="checkbox-signin">Remember me</label>
                            </div>
                        </div>

                        <div class="mb-3 mb-0 text-center">
                            <button class="btn btn-green" type="submit"> Log In </button>
                        </div>

                    </form>
                </div> <!-- end card-body -->
            </div>
            <!-- end card -->

            <div class="row mt-3">
                <div class="col-12 text-center">
                    <p class="text-muted">Don't have an account? <a href="{{ route('register') }}" class="text-muted ms-1"><b>Sign Up</b></a></p>
                </div> <!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- end col -->
    </div>
    <!-- end row -->
</div>
@endsection
