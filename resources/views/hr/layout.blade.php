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
                  <p class="mb-1 text-info">HR</p>
                </div>
              </a>
              <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                <a class="dropdown-item" href="{{url('/admin/landing-page')}}">
                  <i class="mdi mdi-cached mr-2 text-info"></i><span class="text-gray">Admin</span></a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{url('inventory/landing-page')}}">
                  <i class="mdi mdi-application mr-2 text-info"></i><span class="text-gray">Inventory</span></a>
                   <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="{{url('accounts/landing-page')}}">
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
              <a class="nav-link " href="../../index.html">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon text-danger"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <span class="menu-title">Employees</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-crosshairs-gps menu-icon text-warning"></i>
              </a>
              <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="{{url('hr/employee-details')}}">Employee Details</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('hr/employee-report')}}">Employees Report</a></li>
                 
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#Purchase" aria-expanded="false" aria-controls="Purchase">
                <span class="menu-title">Salary</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-chart-bar menu-icon text-danger"></i>
              </a>
              <div class="collapse" id="Purchase">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="{{url('inventory/purchase-requisition')}}">Salary Calculation</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('inventory/requisition-approval')}}"  > Monthly Salary Report</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('inventory/RFQ')}}" >Pay Slip Print</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('inventory/quote-analysis')}}">Leave Request</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('inventory/purchase-order')}}">Leave Salary Calculation</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('inventory/purchase-approval')}}">Expiry Passport</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('inventory/grn')}}">Expiry Residence</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('inventory/purchase-invoice')}}">Expiry License</a></li>
                 
                  <li class="nav-item"> <a class="nav-link" href="{{url('inventory/purchase-cost')}}">Expiry Vehicle </a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('inventory/cost-calculation')}}">Monthly Employee Expenses </a></li>
             
                  <li class="nav-item"> <a class="nav-link" href="../../pages/ui-features/typography.html">Employee Expenses Direct </a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('inventory/pending-grn-report')}}">Employee Expenses Total</a></li>
                 
                                  </ul>
              </div>
            </li>
          <!-- <li class="nav-item">
              <a class="nav-link" href="/admin/account-details">
                <span class="menu-title"></span>
                <i class="mdi mdi-file-chart menu-icon text-success"></i>
              </a>
            </li> -->
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#Sales" aria-expanded="false" aria-controls="Sales">
                <span class="menu-title">Leave</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-file-chart menu-icon text-danger"></i>
              </a>
              <div class="collapse" id="Sales">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="{{url('inventory/enquiry')}}">Enquiry Register</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('inventory/sales-quotation')}}">Sales Quotation</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('inventory/proforma-invoice')}}">Proforma Invoice</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('inventory/sales-order')}}">Sales Order</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('inventory/delivery-note')}}">Delivery Note</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('inventory/delivery-return')}}">Delivery Note Return</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('inventory/sales-invoice')}}">Sales Invoice</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('inventory/sales-return')}}">Sales Return</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('inventory/do-report')}}">Delivery Note Report</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('inventory/invoice-report')}}">Sales Invoice Report</a></li>
                 <li class="nav-item"> <a class="nav-link" href="{{url('inventory/ageing')}}">Ageing Report</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('inventory/sales-ageing')}}">Sales Ageing</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('inventory/salesgraph')}}">Sales Graph</a></li>
                  
                                  </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#hr" aria-expanded="false" aria-controls="hr">
                <span class="menu-title">Report</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-history menu-icon text-danger"></i>
              </a>
              <div class="collapse" id="hr">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="{{url('/inventory/opening-stock')}}">Opening Stock</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('/inventory/stock-issue')}}">Stock Issue</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('/inventory/material-issue')}}">Project Material Issue</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('/inventory/stock-issue-return')}}">Stock Issue Return</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('/inventory/stock-transfer')}}">Stock Transfer</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('/inventory/stock-adjustment')}}">Stock Adjustment</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('/inventory/stock-issue-report')}}">Stock Issue Report</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('/inventory/current-stock-report')}}">Current Stock Report</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('/inventory/stock-as-on-report')}}">Stock As On Report</a></li>
                  <li class="nav-item"> <a class="nav-link" href="#">Stock Ledger</a></li>
                  <li class="nav-item"> <a class="nav-link" href="#">Opening Stock Report</a></li>
                  <li class="nav-item"> <a class="nav-link" href="#">Closing Stock Report</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('/inventory/stock-movement-report')}}">Stock Movement Report</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('/inventory/nil-stock-report')}}">Nil Stock Report</a></li>
                </ul>
              </div>
            </li>
         <li class="nav-item">
              <a class="nav-link" href="{{url('/hr/utility')}}">
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