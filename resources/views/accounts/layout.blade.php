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
  <link rel="stylesheet" href="../../assets/css/buttons.dataTables.min.css">
  <link rel="stylesheet" href="../../assets/css/select2.min.css"  />
<link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.1.0/css/dataTables.dateTime.min.css"  />
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
                  <p class="mb-1 text-info">Accounts</p>
                </div>
              </a>
              <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                <a class="dropdown-item" href="{{url('/admin/landing-page')}}">
                  <i class="mdi mdi-cached mr-2 text-info"></i><span class="text-gray">Admin</span></a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{url('/inventory/landing-page')}}">
                  <i class="mdi mdi-application mr-2 text-info"></i><span class="text-gray">Inventory</span></a>
                   <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="{{url('hr/landing-page')}}">
                  <i class="mdi mdi-logout mr-2 text-info"></i><span class="text-gray">HR</span></a>
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
                <h6 class="p-3 mb-0">Notifications</h6>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-success">
                      <i class="mdi mdi-calendar"></i>
                    </div>
                  </div>
                  <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                    <h6 class="preview-subject font-weight-normal mb-1">Event today</h6>
                    <p class="text-gray ellipsis mb-0"> Just a reminder that you have an event today </p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-warning">
                      <i class="mdi mdi-settings"></i>
                    </div>
                  </div>
                  <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                    <h6 class="preview-subject font-weight-normal mb-1">Settings</h6>
                    <p class="text-gray ellipsis mb-0"> Update dashboard </p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-info">
                      <i class="mdi mdi-link-variant"></i>
                    </div>
                  </div>
                  <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                    <h6 class="preview-subject font-weight-normal mb-1">Launch Admin</h6>
                    <p class="text-gray ellipsis mb-0"> New admin wow! </p>
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
              <a class="nav-link " href="{{url('accounts/landing-page')}}">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon text-danger"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <span class="menu-title">Master</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-crosshairs-gps menu-icon text-warning"></i>
              </a>
              <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="{{url('/accounts/account-details')}}">Account Head</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('accounts/opening-details')}}">Opening</a></li>
                
                  <li class="nav-item"> <a class="nav-link" href="{{url('accounts/executive-overhead')}}">Executive Overhead</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('accounts/executive-commission')}}">Commission Calculation</a></li>
                
                  
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#Purchase" aria-expanded="false" aria-controls="Purchase">
                <span class="menu-title">Accounts</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-chart-bar menu-icon text-danger"></i>
              </a>
              <div class="collapse" id="Purchase">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="{{url('accounts/regular-entry')}}">Regular Voucher Entry</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('accounts/optional-entry')}}"  >Optional Voucher Entry</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('accounts/regularize-entry')}}" >Regularize Voucher Entry</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('accounts/bank-reconciliation')}}">Bank Reconciliation</a></li>
                  
                                  </ul>
              </div>
            </li>
          
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#Sales" aria-expanded="false" aria-controls="Sales">
                <span class="menu-title">Reports</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-file-chart menu-icon text-danger"></i>
              </a>
              <div class="collapse" id="Sales">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="{{url('accounts/day-book')}}">Day Book</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('accounts/journal')}}">Journal</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('accounts/cash-book')}}">Cash Book</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('accounts/bank-book')}}">Bank Book</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('accounts/ledger')}}">General Ledger</a></li>
                  <li class="nav-item"> <a class="nav-link" href="#">Schedule</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('accounts/trial-balance')}}">Trial Balance</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('inventory/sales-return')}}">Trading & P & L A/C</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('inventory/do-report')}}">Balance Sheet</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('accounts/profit-analysis')}}">Profit Analysis</a></li>
                 <li class="nav-item"> <a class="nav-link" href="{{url('accounts/items-profit')}}">Profit Analysis Itemwise</a></li>
                 <li class="nav-item"> <a class="nav-link" href="{{url('accounts/product-history')}}">Product Sales History</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('accounts/post-dated-cheque')}}">Post Dated Cheque Report</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('accounts/uninvoiced-do')}}">Uninvoiced DO </a></li>
                      <li class="nav-item"> <a class="nav-link" href="{{url('accounts/undelivered-so')}}">SO Not Delivered</a></li>
                      <li class="nav-item"> <a class="nav-link" href="{{url('accounts/receivable-summary')}}">Receivable Summary</a></li>
                      <li class="nav-item"> <a class="nav-link" href="{{url('accounts/commission-details')}}">Commission Details</a></li>
                      <li class="nav-item"> <a class="nav-link" href="{{url('accounts/stocks-details')}}">Stock Value</a></li>
                  
                                  </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#hr" aria-expanded="false" aria-controls="hr">
                <span class="menu-title">Receipt</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-history menu-icon text-danger"></i>
              </a>
              <div class="collapse" id="hr">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="{{url('/accounts/receipts')}}">Customer Receipt</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('/accounts/customer-advance')}}">Customer Advance</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('/accounts/ageing')}}">Ageing Report</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('/accounts/sales-ageing')}}">Sales Ageing</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('/accounts/sales-report')}}">Sales Report</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('/accounts/receipt-report')}}">Receipts Detailed Report</a></li>
                  
                </ul>
              </div>
            </li>
         
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#project" aria-expanded="false" aria-controls="project">
                <span class="menu-title">Payment</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-table menu-icon text-danger"></i>
              </a>
              <div class="collapse" id="project">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="{{url('/accounts/vendor-payment')}}">Vendor Payment</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('/accounts/vendor-advance')}}">Vendor Advance</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('accounts/expense-entry')}}">Project Expense Entry</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('accounts/expense-settle')}}">Project Expense Settlement</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('accounts/ageing-report')}}">Ageing Report</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('accounts/purchase-ageing')}}">Purchase Ageing</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('accounts/puchase-report')}}">Purchase Report</a></li>
                  
                  

                </ul>
              </div>
            </li>
           
           
             <li class="nav-item">
              <a class="nav-link" href="{{url('/inventory/utility')}}">
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
<script src="../../assets/js/dataTables.buttons.min.js"></script>
  <script src="../../assets/js/jszip.min.js"></script>
  <script src="../../assets/js/pdfmake.min.js"></script>
  <script src="../../assets/js/vfs_fonts.js"></script>
  <script src="../../assets/js/buttons.html5.min.js"></script>
   <script src="../../assets/js/buttons.print.min.js"></script>
  <script src="../../assets/js/yearpicker.js" ></script>
<script src="../../assets/js/find.js" ></script>
 <script src="../../assets/js/sum.js"></script>
<script src="../../assets/vendors/chart.js/Chart.min.js"></script>
<script src="../../assets/js/chart.js"></script>
    

<script src="../../assets/js/select2.min.js"></script>
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