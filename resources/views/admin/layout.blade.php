<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Agrim ERP</title>
  <link rel="stylesheet" href="../../assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="../../assets/css/style.css">
  <link rel="shortcut icon" href="../../assets/images/favicon.ico" />
  <link rel="stylesheet" href="../../assets/css/jquery-ui.css">
  <link rel="stylesheet" href="../../assets/css/yearpicker.css">
  <link rel="stylesheet" href="../../assets/css/jquery.dataTables.min.css">
  <link href="../../assets/css/select2.min.css" rel="stylesheet" />

  </head>
  <body>
    <div class="container-scroller">
     <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
          <a class="navbar-brand brand-logo capp" href="">{{session('cname')}}</a>
          <a class="navbar-brand brand-logo-mini" href=""><img src="../../assets/images/1.png" alt="logo" /></a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-stretch">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
          </button>
          
          <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item d-none d-lg-block full-screen-link">
              <a class="nav-link">
                <i class="mdi mdi-account mr-2  " title="user"></i><p class="mb-1 text-info capp">{{session('name')}}</p>
              </a>
            </li>
            <li class="nav-item d-none d-lg-block full-screen-link">
              <a class="nav-link">
                <i class="mdi mdi-calendar-check mr-2" title="financial-year"></i><p class="mb-1 text-info">{{session('fyear')}}</p>
              </a>
            </li>
            <li class="nav-item d-none d-lg-block full-screen-link">
              <a class="nav-link">
                <i class="mdi mdi-calendar mr-2" title="working-date"></i><p class="mb-1 text-info">{{session('wdate')}}</p>
              </a>
            </li>
            <li class="nav-item d-none d-lg-block full-screen-link">
              <a class="nav-link">
                <i class="mdi mdi-desktop-mac mr-2" title="system-date"></i><p class="mb-1 text-info">{{date('d-M-Y')}}</p>
              </a>
            </li>
            
            <li class="nav-item nav-profile dropdown">
              <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                <div class="nav-profile-text">
                  <p class="mb-1 text-info">Admin</p>
                </div>
              </a>
              <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                <a class="dropdown-item" href="{{url('/inventory/landing-page')}}">
                  <i class="mdi mdi-cached mr-2 text-info"></i><span class="text-gray">Inventory</span></a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{url('hr/landing-page')}}">
                  <i class="mdi mdi-application mr-2 text-info"></i><span class="text-gray">HR</span></a>
                   <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="{{url('/accounts/landing-page')}}">
                  <i class="mdi mdi-logout mr-2 text-info"></i><span class="text-gray">Accounts</span></a>
                   <div class="dropdown-divider"></div>
                 
              </div>
            </li>
            <li class="nav-item d-none d-lg-block full-screen-link">
              <a class="nav-link">
                <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
              </a>
            </li>
           
            <li class="nav-item dropdown">
              <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                <i class="mdi mdi-bell-outline"></i>
                <span class="count-symbol bg-danger"></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                <h6 class="p-3 mb-0">Hello Admin</h6>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-success">
                      <i class="mdi mdi-calendar"></i>
                    </div>
                  </div>
                  <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                    <h6 class="preview-subject font-weight-normal mb-1">SIT BACK & RELAX</h6>
                   <!--  <p class="text-gray ellipsis mb-0"> Just a reminder that you have an event today </p> -->
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                
               
                
                
                <h6 class="p-3 mb-0 text-center">See all notifications</h6>
              </div>
            </li>
            <li class="nav-item nav-logout d-none d-lg-block">
              <a class="nav-link" href="{{'/logout'}}">
                <i class="mdi mdi-power"></i>
              </a>
            </li>
            <!-- <li class="nav-item nav-settings d-none d-lg-block">
              <a class="nav-link" href="#">
                <i class="mdi mdi-format-line-spacing"></i>
              </a>
            </li> -->
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:../../partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            
            <li class="nav-item">
              <a class="nav-link " href="{{url('/admin/landing-page')}}">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon text-danger"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <span class="menu-title">General</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-crosshairs-gps menu-icon text-warning"></i>
              </a>
              <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="/admin/company-information">Company Info</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/admin/financial-year">Financial Year</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/admin/privilege">Privilege</a></li>
                  <li class="nav-item"> <a class="nav-link" href="../../pages/ui-features/typography.html">Transfer Privilege</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/admin/users">User</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/admin/voucher-number">Voucher No. Generation</a></li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#Inventory" aria-expanded="false" aria-controls="Inventory">
                <span class="menu-title">Inventory</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-chart-bar menu-icon text-danger"></i>
              </a>
              <div class="collapse" id="Inventory">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="/admin/brand">Brand</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/admin/business-type">Business Type</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/admin/currency">Currency</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/admin/customer-details">Customer</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/admin/executive">Executive</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/admin/item-category">Item Category</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/admin/item-group">Item Group</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/admin/item-master">Item Master</a></li>
                  <!-- <li class="nav-item"> <a class="nav-link" href="../../pages/ui-features/typography.html">Item Master Report</a></li> -->
                  <li class="nav-item"> <a class="nav-link" href="/admin/item-bulk-upload">Items Bulk Upload</a></li>
                 <!--  <li class="nav-item"> <a class="nav-link" href="#">Locality</a></li>
                  <li class="nav-item"> <a class="nav-link" href="#">Rate Type</a></li> -->
                  <li class="nav-item"> <a class="nav-link" href="/admin/sales-rate-updation">Sales Rate Updation</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/admin/unit">Unit</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/admin/vendor">Vendor</a></li>
                                  </ul>
              </div>
            </li>
          <li class="nav-item">
              <a class="nav-link" href="/admin/account-details">
                <span class="menu-title">Accounts</span>
                <i class="mdi mdi-file-chart menu-icon text-success"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#hr" aria-expanded="false" aria-controls="hr">
                <span class="menu-title">Human Resource</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-contacts menu-icon text-danger"></i>
              </a>
              <div class="collapse" id="hr">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="/admin/contract-details">Contract</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/admin/employee-details">Employee</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/admin/indemnity-details">Indemnity</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/admin/leave-salary">Leave Salary</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/admin/overtime">Overtime Rates</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/admin/salary-calculation">Salary Calculation</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/admin/vehicle-details">Vehicle Details</a></li>
                  

                </ul>
              </div>
            </li>
          <li class="nav-item">
              <a class="nav-link" href="/admin/utility">
              <span class="menu-title">Utility</span>
                <i class="mdi mdi-table-large menu-icon text-warning"></i>
              </a>
            </li>
           
          </ul>
        </nav>
        <!-- Body Section Start -->
        <div class="main-panel">
          <div class="content-wrapper">
        @yield('content')
      <!-- Body Section Start -->
    </div>
  </div>
    </div>

    <script src="../../assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="../../assets/js/off-canvas.js"></script>
    <script src="../../assets/js/hoverable-collapse.js"></script>
    <script src="../../assets/js/misc.js"></script>
    <script src="../../assets/js/file-upload.js"></script>
    <script src="../../assets/js/jquery-ui.js"></script>
  <script src="../../assets/js/jquery.dataTables.min.js"></script>
  <script src="../../assets/js/yearpicker.js" async></script>
<script src="../../assets/js/find.js" ></script>
<script src="../../assets/js/select2.min.js"></script>
<script src="../../assets/vendors/chart.js/Chart.min.js"></script>
<!--  -->
 <script src="../../assets/js/adminrevenuechart.js"></script> 
    <script type="text/javascript">
      $(document).ready(function () {
    $(".datepicker").datepicker(
      { dateFormat: 'dd-M-yy',
      changeYear: true,
      yearRange: "-100:+0",
      changeMonth: true}).datepicker("setDate",'now');
    $(".editpicker").datepicker(
      { dateFormat: 'dd-M-yy',
      changeYear: true,
      yearRange: "-100:+0",
      changeMonth: true});
});
      $(function() {  
  $('.yearpicker').yearpicker({
    
  });
});
  $('.mySelect2').select2({
  selectOnClose: true
});
</script>
  </body>
</html>