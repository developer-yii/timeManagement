@extends('layouts.login')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xxl-4 col-lg-5">
            <div class="card">
                <!-- Logo-->
                <div class="card-header pt-4 pb-4 text-center bg-primary">
                    <a href="index.html">
                        <span><img src="{{ asset('images/logo.png') }}" alt="" height="18"></span>
                    </a>
                </div>

                <div class="card-body p-4">
                    
                    <div class="text-center w-75 m-auto">
                        <h4 class="text-dark-50 text-center mt-0 fw-bold">Free Sign Up</h4>
                        <p class="text-muted mb-4">Don't have an account? Create your account, it takes less than a minute </p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="fullname" class="form-label">Full Name</label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name') }}" id="name" placeholder="Enter your name" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="emailaddress" class="form-label">Email address</label>
                            <input class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" type="email" id="emailaddress" required placeholder="Enter your email" autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mt-3 mb-3">
                            <label for="user_type" class="form-label">Select Type</label>
                            <br/>
                            <div class="form-check">
                                <input type="radio" id="parent" name="user_type" class="form-check-input" checked value="2">
                                <label class="form-check-label" for="parent">Parent</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" id="teacher" name="user_type" class="form-check-input" value="3">
                                <label class="form-check-label" for="teacher">Teacher</label>
                            </div>
                        </div> 

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter your password" autocomplete="new-password">
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

                        <div class="mb-3">
                            <label for="password" class="form-label">Confirm Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" placeholder="Enter Confirm password">
                                <div class="input-group-text" data-password="false">
                                    <span class="password-eye"></span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkbox-signup">
                                <label class="form-check-label" for="checkbox-signup">I accept <a href="#" class="text-muted">Terms and Conditions</a></label>
                            </div>
                        </div>

                        <div class="mb-3 text-center">
                            <button class="btn btn-primary" type="submit"> Sign Up </button>
                        </div>

                    </form>
                </div> <!-- end card-body -->
            </div>
            <!-- end card -->

            <div class="row mt-3">
                <div class="col-12 text-center">
                    <p class="text-muted">Already have account? <a href="pages-login.html" class="text-muted ms-1"><b>Log In</b></a></p>
                </div> <!-- end col-->
            </div>
            <!-- end row -->

        </div> <!-- end col -->
    </div>
    <!-- end row -->
</div>
<!-- end container -->
@endsection
