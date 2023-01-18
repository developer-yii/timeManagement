<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png')}}">
    <link rel="manifest" href="{{ asset('images/site.webmanifest')}}">

    <!-- Styles -->
    <!-- Datatables css -->
    <link href="{{asset('/')}}theme/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('/')}}theme/css/vendor/responsive.bootstrap5.css" rel="stylesheet" type="text/css" />

    <link href="{{ asset('css/app.min.css') }}" rel="stylesheet" id="app-style">
    <link href="{{ asset('css/icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}?{{time()}}" rel="stylesheet">

    <!-- third party css -->
    <link href="{{ asset('css/vendor/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/vendor/jquery.serialtip.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('/')}}theme/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />
    <!-- third party css end -->

    @yield('css')
</head>
<body class="loading" data-layout-color="light" data-leftbar-theme="dark" data-layout-mode="fluid" data-rightbar-onstart="true">
    <!-- Begin page -->
    <div class="wrapper">
        <!-- ========== Left Sidebar Start ========== -->
        <div class="leftside-menu">

            <!-- LOGO -->
            <a href="{{ route('home') }}" class="logo text-center logo-light">
                <span class="logo-lg">
                    <img src="{{ asset('images/logo.png') }}" alt="" height="60">
                </span>
                <span class="logo-sm">
                    <img src="{{ asset('images/logo.png') }}" alt="" height="16">
                </span>
            </a>

            <!-- LOGO -->
            <a href="{{ route('home') }}" class="logo text-center logo-dark">
                <span class="logo-lg">
                    <img src="{{ asset('images/logo.png') }}" alt="" height="16">
                </span>
                <span class="logo-sm">
                    <img src="{{ asset('images/logo.png') }}" alt="" height="16">
                </span>
            </a>

            <div class="h-100" id="leftside-menu-container" data-simplebar>

                <!--- Sidemenu -->
                <ul class="side-nav">
                    <li class="side-nav-item">
                        <a href="{{ route('student-time-log') }}" class="side-nav-link">
                            {{-- <i class="mdi mdi-view-dashboard-outline"></i> --}}
                            <i class="mdi mdi-calendar-month"></i>
                            <span> Monthly Planner </span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a href="{{ route('student-time-log.monthly_view') }}" class="side-nav-link">
                            {{-- <i class="mdi mdi-view-dashboard-outline"></i> --}}
                            <i class="mdi mdi-calendar-check"></i>
                            <span>  Monthly Student Log </span>
                        </a>
                    </li>

 {{--                    <a href="{{ route('student-time-log.monthly_view') }}"><i class="mdi mdi-calendar-check"></i> Monthly Student Log</a> --}}
                    <li class="side-nav-item">
                        <a href="{{ route('home1') }}" class="side-nav-link">
                            <i class="mdi mdi-chart-bar-stacked"></i>
                            <span> Progress Charts </span>
                        </a>
                    </li>
                    {{-- <a href="{{ route('student-time-log') }}"><i class="mdi mdi-calendar-month"></i> Monthly Planner</a> --}}

                    @if(auth()->user()->user_type == 1)
                    <li class="side-nav-item">
                        <a href="{{ route('users') }}" class="side-nav-link">
                            <i class="mdi mdi-human-queue"></i>
                            <span> Users </span>
                        </a>
                    </li>
                    <li class="side-nav-item">
                        <a href="{{ route('promocode') }}" class="side-nav-link">
                            <i class="mdi mdi-ticket"></i>
                            <span> Promo Codes </span>
                        </a>
                    </li>
                    
                    @endif

                    {{-- <li class="side-nav-item">
                        <a href="{{ route('student-time-log.create') }}" class="side-nav-link"> 
                            <i class="mdi mdi-calendar-plus"></i>
                            <span> Add Student Time/Activity </span>
                        </a>
                    </li> --}}

                    <li class="side-nav-item">
                        <a href="{{ route('student') }}" class="side-nav-link"> 
                            <i class="mdi mdi-human-female-boy"></i>
                            <span> Names/Students List </span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a href="{{ route('subject') }}" class="side-nav-link"> 
                            <i class="mdi mdi-notebook"></i>
                            <span> Subject/Activity List </span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a href="{{ route('holiday') }}" class="side-nav-link"> 
                            <i class="mdi mdi-dance-ballroom"></i>
                            <span> Holiday/Events List </span>
                        </a>
                    </li>

                    {{-- <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarCrm" aria-expanded="false" aria-controls="sidebarCrm" class="side-nav-link">
                            <img src="{{ asset('images/plus.png')}}" height="25"/>
                            <span class="menu-arrow"></span>
                            <span> Add Names/Subjects/Events </span>
                        </a>
                        <div class="collapse" id="sidebarCrm">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="{{ route('student-time-log.create') }}"><i class="mdi mdi-calendar-plus"></i> Add Student Time/Activity</a>
                                </li>
                                <li>
                                    <a href="{{ route('student') }}" class="side-nav-link">
                                        <span><i class="mdi mdi-human-female-boy"></i> Names/Students </span>
                                    </a>                                    
                                </li>
                                <li>
                                    <a href="{{ route('subject') }}" class="side-nav-link">
                                        <span><i class="mdi mdi-notebook"></i> Subject List </span>
                                    </a>                                  
                                </li>
                                <li>
                                    <a href="{{ route('holiday') }}" class="side-nav-link">
                                        <span><i class="mdi mdi-dance-ballroom"></i> Events/Appointments </span>
                                    </a>                                  
                                </li>                                                              
                            </ul>
                        </div>
                    </li> --}}

                    <li class="side-nav-item">
                        <a href="{{ route('help')}}" class="side-nav-link">
                            <i class="mdi mdi-lightbulb-on-outline"></i>
                            <span> Help/Quick Tips </span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a href="{{ route('links.index')}}" class="side-nav-link">
                            <i class="mdi mdi-vector-link"></i>
                            <span> Saved Links </span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a href="{{ route('file.index')}}" class="side-nav-link">
                            <i class="mdi mdi-image-multiple"></i>
                            <span> Saved Photo/Uploads </span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a href="{{ route('idcard')}}" class="side-nav-link">
                            <i class="mdi mdi-card-account-details-outline"></i>
                            <span> ID Card Emails </span>
                        </a>
                    </li>
                </ul>

                <!-- End Sidebar -->

                <div class="clearfix"></div>

            </div>
            <!-- Sidebar -left -->

        </div>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">
                <!-- Topbar Start -->
                <div class="navbar-custom">
                    <ul class="list-unstyled topbar-menu float-end mb-0">
                        <li class="dropdown notification-list" style="display: none;">
                            <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <i class="dripicons-bell noti-icon"></i>
                                <span class="noti-icon-badge"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg">

                                <!-- item-->
                                <div class="dropdown-item noti-title px-3">
                                    <h5 class="m-0">
                                        <span class="float-end">
                                            <a href="javascript: void(0);" class="text-dark">
                                                <small>Clear All</small>
                                            </a>
                                        </span>Notification
                                    </h5>
                                </div>

                                <div class="px-3" style="max-height: 300px;" data-simplebar>

                                    <h5 class="text-muted font-13 fw-normal mt-0">Today</h5>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item p-0 notify-item card unread-noti shadow-none mb-2">
                                        <div class="card-body">
                                            <span class="float-end noti-close-btn text-muted"><i class="mdi mdi-close"></i></span>   
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="notify-icon bg-primary">
                                                        <i class="mdi mdi-comment-account-outline"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 text-truncate ms-2">
                                                    <h5 class="noti-item-title fw-semibold font-14">Datacorp <small class="fw-normal text-muted ms-1">1 min ago</small></h5>
                                                    <small class="noti-item-subtitle text-muted">Caleb Flakelar commented on Admin</small>
                                                </div>
                                              </div>
                                        </div>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item p-0 notify-item card read-noti shadow-none mb-2">
                                        <div class="card-body">
                                            <span class="float-end noti-close-btn text-muted"><i class="mdi mdi-close"></i></span>   
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="notify-icon bg-info">
                                                        <i class="mdi mdi-account-plus"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 text-truncate ms-2">
                                                    <h5 class="noti-item-title fw-semibold font-14">Admin <small class="fw-normal text-muted ms-1">1 hours ago</small></h5>
                                                    <small class="noti-item-subtitle text-muted">New user registered</small>
                                                </div>
                                              </div>
                                        </div>
                                    </a>

                                    <h5 class="text-muted font-13 fw-normal mt-0">Yesterday</h5>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item p-0 notify-item card read-noti shadow-none mb-2">
                                        <div class="card-body">
                                            <span class="float-end noti-close-btn text-muted"><i class="mdi mdi-close"></i></span>   
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="notify-icon">
                                                        @if(auth()->user()->profilephoto)
                                                            <img src="{{ url('/storage/uploads/profile\/').auth()->user()->profilephoto }}" class="img-fluid rounded-circle" alt="" />
                                                        @else
                                                        <img src="{{ asset('images/users/avatar-app.jpeg') }}" class="img-fluid rounded-circle" alt="" />
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 text-truncate ms-2">
                                                    <h5 class="noti-item-title fw-semibold font-14">Cristina Pride <small class="fw-normal text-muted ms-1">1 day ago</small></h5>
                                                    <small class="noti-item-subtitle text-muted">Hi, How are you? What about our next meeting</small>
                                                </div>
                                              </div>
                                        </div>
                                    </a>

                                    <h5 class="text-muted font-13 fw-normal mt-0">30 Dec 2021</h5>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item p-0 notify-item card read-noti shadow-none mb-2">
                                        <div class="card-body">
                                            <span class="float-end noti-close-btn text-muted"><i class="mdi mdi-close"></i></span>   
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="notify-icon bg-primary">
                                                        <i class="mdi mdi-comment-account-outline"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 text-truncate ms-2">
                                                    <h5 class="noti-item-title fw-semibold font-14">Datacorp</h5>
                                                    <small class="noti-item-subtitle text-muted">Caleb Flakelar commented on Admin</small>
                                                </div>
                                              </div>
                                        </div>
                                    </a>

                                     <!-- item-->
                                     <a href="javascript:void(0);" class="dropdown-item p-0 notify-item card read-noti shadow-none mb-2">
                                        <div class="card-body">
                                            <span class="float-end noti-close-btn text-muted"><i class="mdi mdi-close"></i></span>   
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="notify-icon">
                                                        <img src="{{ asset('images/users/avatar-app.jpeg') }}" class="img-fluid rounded-circle" alt="" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 text-truncate ms-2">
                                                    <h5 class="noti-item-title fw-semibold font-14">Karen Robinson</h5>
                                                    <small class="noti-item-subtitle text-muted">Wow ! this admin looks good and awesome design</small>
                                                </div>
                                              </div>
                                        </div>
                                    </a>

                                    <div class="text-center">
                                        <i class="mdi mdi-dots-circle mdi-spin text-muted h3 mt-0"></i>
                                    </div>
                                </div>

                                <!-- All-->
                                <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item border-top border-light py-2">
                                    View All
                                </a>

                            </div>
                        </li>                        
                        <li class="dropdown notification-list">
                            <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                                aria-expanded="false">
                                <span class="account-user-avatar"> 
                                    
                                    @if(auth()->user()->profilephoto)
                                        <img src="{{ url('/storage/uploads/profile\/').auth()->user()->profilephoto }}" class="rounded-circle" alt="user-image" />
                                    @else
                                    <img src="{{ asset('images/users/avatar-app.jpeg') }}" alt="user-image" class="rounded-circle">
                                    @endif
                                </span>
                                <span>
                                    <span class="account-user-name">{{ Auth::user()->name }}</span>
                                    <span class="account-position">
                                        @php
                                            if(Auth::user()->user_type == 1)
                                                echo 'Admin';
                                            else if(Auth::user()->user_type == 2)
                                                echo 'Parent';
                                            else if(Auth::user()->user_type == 3)
                                                echo 'Teacher';
                                            else if(Auth::user()->user_type == 4)
                                                echo 'Affiliate/Business';
                                        @endphp
                                    </span>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                                <!-- item-->
                                <div class=" dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Welcome !</h6>
                                </div>

                                <!-- item-->
                                <a href="{{ route('profile')}}" class="dropdown-item notify-item">
                                    <i class="mdi mdi-account-circle me-1"></i>
                                    <span>My Account</span>
                                </a>

                                @if(auth()->user()->user_type == 1)
                                <!-- item-->
                                <a href="{{ route('subscription.price.show')}}" class="dropdown-item notify-item">
                                    <i class="mdi mdi-currency-usd me-1"></i>
                                    <span>Change Subscription Amount</span>
                                </a>
                                @endif

                                <!-- item-->
                                <a href="{{ route('profile.password') }}" class="dropdown-item notify-item">
                                    <i class="mdi mdi-form-textbox-password me-1"></i>
                                    <span>Change Password</span>
                                </a>

                                <!-- item-->
                                <a href="{{route('logout')}}" class="dropdown-item notify-item">
                                    <i class="mdi mdi-logout me-1"></i>
                                    <span>Logout</span>
                                </a>
                            </div>
                        </li>

                    </ul>
                    {{-- <ul class="list-unstyled topbar-menu float-end m-logo mb-0">
                        <img src="{{ asset('images/logo.png') }}" alt="" height="60">
                    </ul> --}}
                    <a href="/" class="navbar-brand">
                        <img src="{{ asset('images/landing/logo.png') }}" alt="" height="60">
                    </a>
                    <button class="button-menu-mobile open-left">
                        <i class="mdi mdi-menu"></i>
                    </button>
                </div>
                <!-- end Topbar -->
                @yield('content')
            </div>
            <!-- content -->

            <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <script>document.write(new Date().getFullYear())</script> © Homeschool Minutes
                        </div>
                        <div class="col-md-6">
                            <div class="text-md-end footer-links d-none d-md-block">
                                {{-- <a href="javascript: void(0);">About</a> --}}

                                <a href="mailto:info@homeschoolminutes.com">Support</a>
                                <a href="mailto:info@homeschoolminutes.com">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>
    <!-- END wrapper -->

    @yield('modal')
    
    <!-- bundle -->
    <script src="{{ asset('js/vendor.min.js') }}"></script>
    <script src="{{ asset('js/app.min.js') }}"></script>

    <!-- third party js -->
    <script src="{{ asset('js/vendor/apexcharts.min.js') }}?{{time()}}"></script>
    <script src="{{ asset('js/vendor/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('js/vendor/jquery-jvectormap-world-mill-en.js') }}"></script>

    <script src="{{asset('/')}}theme/js/vendor/jquery.dataTables.min.js"></script>
    <script src="{{asset('/')}}theme/js/vendor/dataTables.bootstrap5.js"></script>
    <script src="{{asset('/')}}theme/js/vendor/dataTables.responsive.min.js"></script>
    <script src="{{asset('/')}}theme/js/vendor/responsive.bootstrap5.min.js"></script>
    <script src="{{asset('/')}}js/vendor/jquery.serialtip.min.js"></script>
    <script src="{{asset('/')}}js/vendor/jspdf.umd.min.js"></script>

    <!-- third party js ends -->

    <!-- demo app -->
    <!-- <script src="{{ asset('js/pages/demo.dashboard.js') }}"></script> -->
    <!-- end demo js-->
    <script type="text/javascript">
        var _token = "{{ csrf_token() }}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': _token
            }
        });
        
        function show_toast(toast_message,toast_type) {
            if(toast_type == 'success')
                $.NotificationApp.send("Success!", toast_message, "top-right", "rgba(0,0,0,0.2)", toast_type);
            else if(toast_type == 'error')
                $.NotificationApp.send("", toast_message, "top-right", "rgba(0,0,0,0.2)", toast_type);
        }       

        $(document).ready(function(){
            $("form").attr('autocomplete', 'off');
        });

    </script>
    @yield('js')
    @yield('pagejs')
</body>
</html>
