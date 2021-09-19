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
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper bgimg" >
        <div class="content-wrapper d-flex align-items-center auth" >
          <div class="row flex-grow" style="background-image: url('../../assests/images/bluesky.jpg');" >
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left p-5">
                <div class="brand-logo">
                  <img src="../../assets/images/logo1.png"><b>AGRIM INFORMATION SYSTEM</b>
                </div>
                                                                        @if (session('status'))
<div class="alert alert-success" role="alert">
  <button type="button" class="close" data-dismiss="alert">×</button>
  {{ session('status') }}
</div>
@elseif(session('failed'))
<div class="alert alert-danger" role="alert">
  <button type="button" class="close" data-dismiss="alert">×</button>
  {{ session('failed') }}
</div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
      <button type="button" class="close" data-dismiss="alert">×</button>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
            <form class="forms-sample pt-3" action ="{{('/updatepass')}}" method = "post" enctype="multipart/form-data" >
              <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                  
                  <input type="hidden" name="id" class="form-control input_user" value="{{$id}}" placeholder="" required="">
                 
                  <div class="form-group">
                    <input type="password" class="form-control form-control" id="exampleInputPassword1" placeholder="Password" name="password" >
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control" id="exampleInputPassword1" placeholder=" Confirm Password" name="password_confirmation" >
                  </div>
                  <div class="mt-3">
                    <button type="submit"  class="btn btn-block btn-gradient-info btn-lg font-weight-medium auth-form-btn" href="">UPDATE </button>
                   
                  </div>
                  </form>
                  
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
  
<script src="../../assets/js/jquery-3.6.0.min.js"></script>
<script src="../../assets/vendors/js/vendor.bundle.base.js"></script>

    <script src="../../assets/js/off-canvas.js"></script>
    <script src="../../assets/js/hoverable-collapse.js"></script>
    <script src="../../assets/js/misc.js"></script>
    <script src="../../assets/js/jquery-ui.js"></script>
     <script type="text/javascript">
 
</script>
  </body>
</html>