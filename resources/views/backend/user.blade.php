<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Pages</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="/backend/Admin/dist/assets/images/favicon2.ico">

        <!-- third party css -->
        <link href="/backend/Admin/dist/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        <link href="/backend/Admin/dist/assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        <link href="/backend/Admin/dist/assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        <link href="/backend/Admin/dist/assets/libs/datatables.net-select-bs5/css//select.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        <!-- third party css end -->

		<!-- App css -->

		<link href="/backend/Admin/dist/assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />

		<!-- icons -->
		<link href="/backend/Admin/dist/assets/css/icons.min.css" rel="stylesheet" type="text/css" />

    </head>

    <!-- body start -->
    <body class="loading" data-layout-color="light"  data-layout-mode="default" data-layout-size="fluid" data-topbar-color="light" data-leftbar-position="fixed" data-leftbar-color="light" data-leftbar-size='default' data-sidebar-user='true'>

        <!-- Begin page -->
        <div id="wrapper">
            
            <!-- Topbar Start -->
            <div class="navbar-custom">
                    <ul class="list-unstyled topnav-menu float-end mb-0">

                        
    
                        <li class="dropdown d-inline-block d-lg-none">
                            <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <i class="fe-search noti-icon"></i>
                            </a>
                            <div class="dropdown-menu dropdown-lg dropdown-menu-end p-0">
                                <form class="p-3">
                                    <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                </form>
                            </div>
                        </li>
            
                       
    
                        <li class="dropdown notification-list topbar-dropdown">
                            <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <img src="/backend/Admin/dist/assets/images/users/user-1.jpg" alt="user-image" class="rounded-circle">
                                <span class="pro-user-name ms-1">
                                   <i class="mdi mdi-chevron-down"></i> 
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
                                <!-- item-->
                                <div class="dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Welcome !</h6>
                                </div>
    
                              
    
                                <div class="dropdown-divider"></div>
    
                                <!-- item-->
                                <a href="/admin/logout" class="dropdown-item notify-item">
                                    <i class="fe-log-out"></i>
                                    <span>Logout</span>
                                </a>
    
                            </div>
                        </li>
    
                       
                    </ul>
    
                    <!-- LOGO -->
                    <div class="logo-box">
                        <a href="index.html" class="logo logo-light text-center">
                            <span class="logo-sm">
                                <img src="/backend/Admin/dist/assets/images/logo-dark.jpg" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="/backend/Admin/dist/assets/images/logo-dark.jpg" alt="" height="16">
                            </span>
                        </a>
                        <a href="index.html" class="logo logo-dark text-center">
                            <span class="logo-sm">
                                <img src="/backend/Admin/dist/assets/images/logo-dark.jpg" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="/backend/Admin/dist/assets/images/logo-dark.jpg" alt="" height="45">
                            </span>
                        </a>
                    </div>

                    <ul class="list-unstyled topnav-menu topnav-menu-left mb-0">
                        <li>
                            <button class="button-menu-mobile disable-btn waves-effect">
                                <i class="fe-menu"></i>
                            </button>
                        </li>
    
                        <li>
                            <h4 class="page-title-main">All Users</h4>
                        </li>
            
                    </ul>

                    <div class="clearfix"></div> 
               
            </div>
            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
            @include('backend.sideber')
            <!-- Left Sidebar End -->
            
            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="mt-0 header-title">All Users</h4>
                                       
    
                                        <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                                            <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Status</th>                                               
                                                <th>Action</th>
                                            </tr>
                                            </thead>
    
    
                                            <tbody>
                                            <tr>
                                            @foreach($users as $user)
                                                <td>{{ $user->id }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->status ? 'Published':'Draft' }}</td>                                                
                                                <td><a href="{{url('admin/user/' . $user->id.  '/edit' ) }}" class = "btn btn-info">Edit</a>
                                                    <a href="{{url('admin/user/' . $user->id ) }}" class = "btn btn-danger">Delete</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                               
                            </div>
                        </div> <!-- end row -->


                      
                      
                        
                    </div> <!-- container-fluid -->

                </div> <!-- content -->

               

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->

        <!-- Right Sidebar -->
        <div class="right-bar">

            <div data-simplebar class="h-100">

                <div class="rightbar-title">
                    <a href="javascript:void(0);" class="right-bar-toggle float-end">
                        <i class="mdi mdi-close"></i>
                    </a>
                    <h4 class="font-16 m-0 text-white">Theme Customizer</h4>
                </div>
        
                <!-- Tab panes -->
                <div class="tab-content pt-0">  

                    <div class="tab-pane active" id="settings-tab" role="tabpanel">

                        <div class="p-3">
                            <div class="alert alert-warning" role="alert">
                                <strong>Customize </strong> the overall color scheme, Layout, etc.
                            </div>

                            <h6 class="fw-medium font-14 mt-4 mb-2 pb-1">Color Scheme</h6>
                            <div class="form-check form-switch mb-1">
                                <input type="checkbox" class="form-check-input" name="layout-color" value="light"
                                    id="light-mode-check" checked />
                                <label class="form-check-label" for="light-mode-check">Light Mode</label>
                            </div>

                            <div class="form-check form-switch mb-1">
                                <input type="checkbox" class="form-check-input" name="layout-color" value="dark"
                                    id="dark-mode-check" />
                                <label class="form-check-label" for="dark-mode-check">Dark Mode</label>
                            </div>

                            <!-- Width -->
                            <h6 class="fw-medium font-14 mt-4 mb-2 pb-1">Width</h6>
                            <div class="form-check form-switch mb-1">
                                <input type="checkbox" class="form-check-input" name="layout-size" value="fluid" id="fluid" checked />
                                <label class="form-check-label" for="fluid-check">Fluid</label>
                            </div>
                            <div class="form-check form-switch mb-1">
                                <input type="checkbox" class="form-check-input" name="layout-size" value="boxed" id="boxed" />
                                <label class="form-check-label" for="boxed-check">Boxed</label>
                            </div>

                            <!-- Menu positions -->
                            <h6 class="fw-medium font-14 mt-4 mb-2 pb-1">Menus (Leftsidebar and Topbar) Positon</h6>

                            <div class="form-check form-switch mb-1">
                                <input type="checkbox" class="form-check-input" name="leftbar-position" value="fixed" id="fixed-check"
                                    checked />
                                <label class="form-check-label" for="fixed-check">Fixed</label>
                            </div>

                            <div class="form-check form-switch mb-1">
                                <input type="checkbox" class="form-check-input" name="leftbar-position" value="scrollable"
                                    id="scrollable-check" />
                                <label class="form-check-label" for="scrollable-check">Scrollable</label>
                            </div>

                            <!-- Left Sidebar-->
                            <h6 class="fw-medium font-14 mt-4 mb-2 pb-1">Left Sidebar Color</h6>

                            <div class="form-check form-switch mb-1">
                                <input type="checkbox" class="form-check-input" name="leftbar-color" value="light" id="light" />
                                <label class="form-check-label" for="light-check">Light</label>
                            </div>

                            <div class="form-check form-switch mb-1">
                                <input type="checkbox" class="form-check-input" name="leftbar-color" value="dark" id="dark" checked/>
                                <label class="form-check-label" for="dark-check">Dark</label>
                            </div>

                            <div class="form-check form-switch mb-1">
                                <input type="checkbox" class="form-check-input" name="leftbar-color" value="brand" id="brand" />
                                <label class="form-check-label" for="brand-check">Brand</label>
                            </div>

                            <div class="form-check form-switch mb-3">
                                <input type="checkbox" class="form-check-input" name="leftbar-color" value="gradient" id="gradient" />
                                <label class="form-check-label" for="gradient-check">Gradient</label>
                            </div>

                            <!-- size -->
                            <h6 class="fw-medium font-14 mt-4 mb-2 pb-1">Left Sidebar Size</h6>

                            <div class="form-check form-switch mb-1">
                                <input type="checkbox" class="form-check-input" name="leftbar-size" value="default"
                                    id="default-size-check" checked />
                                <label class="form-check-label" for="default-size-check">Default</label>
                            </div>

                            <div class="form-check form-switch mb-1">
                                <input type="checkbox" class="form-check-input" name="leftbar-size" value="condensed"
                                    id="condensed-check" />
                                <label class="form-check-label" for="condensed-check">Condensed <small>(Extra Small size)</small></label>
                            </div>

                            <div class="form-check form-switch mb-1">
                                <input type="checkbox" class="form-check-input" name="leftbar-size" value="compact"
                                    id="compact-check" />
                                <label class="form-check-label" for="compact-check">Compact <small>(Small size)</small></label>
                            </div>

                            <!-- User info -->
                            <h6 class="fw-medium font-14 mt-4 mb-2 pb-1">Sidebar User Info</h6>

                            <div class="form-check form-switch mb-1">
                                <input type="checkbox" class="form-check-input" name="sidebar-user" value="true" id="sidebaruser-check" />
                                <label class="form-check-label" for="sidebaruser-check">Enable</label>
                            </div>


                            <!-- Topbar -->
                            <h6 class="fw-medium font-14 mt-4 mb-2 pb-1">Topbar</h6>

                            <div class="form-check form-switch mb-1">
                                <input type="checkbox" class="form-check-input" name="topbar-color" value="dark" id="darktopbar-check"
                                    checked />
                                <label class="form-check-label" for="darktopbar-check">Dark</label>
                            </div>

                            <div class="form-check form-switch mb-1">
                                <input type="checkbox" class="form-check-input" name="topbar-color" value="light" id="lighttopbar-check" />
                                <label class="form-check-label" for="lighttopbar-check">Light</label>
                            </div>

                            <div class="d-grid mt-4">
                                <button class="btn btn-primary" id="resetBtn">Reset to Default</button>
                                <a href="https://1.envato.market/admintoadmin" class="btn btn-danger mt-3" target="_blank"><i class="mdi mdi-basket me-1"></i> Purchase Now</a>
                            </div>

                        </div>

                    </div>
                </div>

            </div> <!-- end slimscroll-menu-->
        </div>
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- Vendor -->
        <script src="/backend/Admin/dist/assets/libs/jquery/jquery.min.js"></script>
        <script src="/backend/Admin/dist/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="/backend/Admin/dist/assets/libs/simplebar/simplebar.min.js"></script>
        <script src="/backend/Admin/dist/assets/libs/node-waves/waves.min.js"></script>
        <script src="/backend/Admin/dist/assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
        <script src="/backend/Admin/dist/assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
        <script src="/backend/Admin/dist/assets/libs/feather-icons/feather.min.js"></script>

        <!-- third party js -->
        <script src="/backend/Admin/dist/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="/backend/Admin/dist/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
        <script src="/backend/Admin/dist/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="/backend/Admin/dist/assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
        <script src="/backend/Admin/dist/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="/backend/Admin/dist/assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
        <script src="/backend/Admin/dist/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="/backend/Admin/dist/assets/libs/datatables.net-buttons/js/buttons.flash.min.js"></script>
        <script src="/backend/Admin/dist/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="/backend/Admin/dist/assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
        <script src="/backend/Admin/dist/assets/libs/datatables.net-select/js/dataTables.select.min.js"></script>
        <script src="/backend/Admin/dist/assets/libs/pdfmake/build/pdfmake.min.js"></script>
        <script src="/backend/Admin/dist/assets/libs/pdfmake/build/vfs_fonts.js"></script>
        <!-- third party js ends -->

        <!-- Datatables init -->
        <script src="/backend/Admin/dist/assets/js/pages/datatables.init.js"></script>

        <!-- App js -->
        <script src="/backend/Admin/dist/assets/js/app.min.js"></script>
        
    </body>
</html>