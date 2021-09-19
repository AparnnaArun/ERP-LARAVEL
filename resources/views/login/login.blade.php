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
            <form class="forms-sample pt-3" action ="{{('/createlogin')}}" method = "post" enctype="multipart/form-data" >
              <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token1"/>
                  <div class="form-group">
                    <select class="forms" id="" name="compid" >
                      
              @foreach($comps as $comp)
              <option value="{{$comp->id}}" >{{$comp->short_name}}</option>
              @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <select class="forms" id="exampleInputEmail1" name="fyear" >
                    
                       @foreach($fyears as $fyear)
              <option value="{{$fyear->finyear}}" >{{$fyear->finyear}}</option>
              @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control form-control datepicker" id="" placeholder="Working Date" name="wdate" value="{{ old('wdate') }}" >
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control form-control" id="exampleInputEmail1" placeholder="LoginName" name="lname" value="{{ old('lname') }}">
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control" id="exampleInputPassword1" placeholder="Password" name="password" >
                  </div>
                  <div class="mt-3">
                    <button type="submit"  class="btn btn-block btn-gradient-info btn-lg font-weight-medium auth-form-btn" href="">SIGN IN</button>
                   
                  </div>
                  </form>
                  <br/>
                  <a href="" class="" data-toggle="modal" data-target=".forgetpassword" id="exampleInputPassword1" placeholder="" name="" >Forgot Password</a>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
 <!--  ///////////////////////////////POP UP ////////////////////// -->
     <div class="modal fade forgetpassword" id="myModalHorizontal4" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Forgot Password</h4>
        <button type="button" class="close" 
        data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        
      </div>
      <!-- Modal Body -->
      <div class="modal-body">
        <form class="form-horizontal">
          <div class="form-group">
            <div class="col-sm-12">
              <input type="email" class="form-control" id="f_email"  placeholder="email"/>
            </div>
          </div>
         

          
          <!--f_mssg-->
          
          <div class="form-group">
            <div class="col-sm-12">
             <span id="f_mssg"></span>
            </div>
          </div>
          <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="f_button" class="btn btn-primary">Save changes</button>
      </div>
        </form>
      </div>
      <!-- Modal Footer -->
    </div>
  </div>
</div>

<script src="../../assets/vendors/js/vendor.bundle.base.js"></script>

    <script src="../../assets/js/off-canvas.js"></script>
    <script src="../../assets/js/hoverable-collapse.js"></script>
    <script src="../../assets/js/misc.js"></script>
    <script src="../../assets/js/jquery-ui.js"></script>
     <script type="text/javascript">
      $(document).ready(function () {
    $(".datepicker").datepicker(
      { dateFormat: 'dd-M-yy',
      changeYear: true,
      changeMonth: true}).datepicker("setDate",'now');

});
$(document).ready(function(){
$("#f_button").click(function(){
$("#f_button").html('Please wait....');
 $("#f_button").attr("disabled","disabled");
 email=$("#f_email").val();
 token=$("#token1").val();
 //alert(email);
 $.ajax({
         type: "POST",
         url: "{{url('ajax-forget')}}",
         data: {email:email,_token:token},
         dataType: "html",  
         success: 
              function(data,status){
                //alert(data);
               $("#f_mssg").html(data);
            
                $("#f_button").html('Submit');
                $("#f_button").removeAttr("disabled","disabled");

           }
          });

          });
});
</script>
  </body>
</html>