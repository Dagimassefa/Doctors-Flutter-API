<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>MLM Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="/backend/Admin/dist/assets/images/favicon2.ico">
        <!-- Plugins css -->
        <link href="/backend/Admin/dist/assets/libs/quill/quill.core.css" rel="stylesheet" type="text/css" />
        <link href="/backend/Admin/dist/assets/libs/quill/quill.bubble.css" rel="stylesheet" type="text/css" />
        <link href="/backend/Admin/dist/assets/libs/quill/quill.snow.css" rel="stylesheet" type="text/css" />
        <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

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

                        <li class="d-none d-lg-block">
                            <form class="app-search">
                                <div class="app-search-box">
                                    
                                    <div class="dropdown-menu dropdown-lg" id="search-dropdown">
                                        
                                        <div class="notification-list">
                                           
                                        </div>
            
                                    </div> 
                                </div>
                            </form>
                        </li>
    
                        
    
                        <li class="dropdown notification-list topbar-dropdown">
                            <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <img src="/backend/Admin/dist/assets/images/users/user-1.jpg" alt="user-image" class="rounded-circle">
                                <span class="pro-user-name ms-1">
                                    <i class="mdi mdi-chevron-down"></i> 
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
                               
                                <div class="dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Welcome !</h6>
                                </div>
    
                                
                               
    
                                <div class="dropdown-divider"></div>
    
                                
                                <a href="/admin/logout" class="dropdown-item notify-item">
                                    <i class="fe-log-out"></i>
                                    <span>Logout</span>
                                </a>
    
                            </div>
                        </li>
    
                       
    
                    </ul>
    
                    <!-- LOGO -->
                    <div class="logo-box">
                        
                        <a href="index.html" class="logo logo-dark text-center">
                            
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
                            <h4 class="page-title-main">Create Page</h4>
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
                                    @include('backend.message')
                                        <h4 class="header-title">Create New Page</h4>
                                       

                                        
                                        <form  action="{{url('admin/user' ) }}" method = "POST" enctype = "multipart/form-data">
                                           @csrf
                                            <div class="mb-3">
                                                <label for="title" class="form-label">Name :</label>
                                                <input type="text" class="form-control" name="name" id="name" required="">
                                            </div>

                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email :</label>
                                                <input type="email" id="email" class="form-control" name="email" data-parsley-trigger="change" required="">
                                            </div>

                                            <div class="mb-3">
                                                <label for="subheading" class="form-label">Password :</label>
                                                <input type="text" id="sub_heading" class="form-control" name="password" data-parsley-trigger="change" required="">
                                            </div>

                                           
                                          
                                            

                                            <div class="mb-3">
                                                <label for="heard" class="form-label">Status:</label>
                                                <select  name ="status" id="heard" class="form-select" required="">
                                                <option value=1>Publish</option>
                                                <option value=0>Draft</option>
                                                </select>
                                            </div>

                                           

                                            <div>
                                                <!-- <input type="submit" class="btn btn-success" value="Create"> -->
                                                <button class="btn btn-primary">Create User</button>
                                                
                                            </div>

                                        </form>
                                    </div>
                                </div> <!-- end card-->
                            </div> <!-- end col-->
                        </div>
                        <!-- end row-->


                      
                        
                    </div> <!-- container -->

                </div> <!-- content -->

               

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->

       

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

         <!-- Plugins js -->
         <script src="/backend/Admin/dist/assets/libs/quill/quill.min.js"></script>

        <!-- Init js-->
        <script src="/backend/Admin/dist/assets/js/pages/form-quilljs.init.js"></script>
        <!-- Plugin js-->
        <script src="/backend/Admin/dist/assets/libs/parsleyjs/parsley.min.js"></script>

        <!-- Validation init js-->
        <script src="/backend/Admin/dist/assets/js/pages/form-validation.init.js"></script>

        <!-- App js -->
        <script src="/backend/Admin/dist/assets/js/app.min.js"></script>
        
    </body>
</html>