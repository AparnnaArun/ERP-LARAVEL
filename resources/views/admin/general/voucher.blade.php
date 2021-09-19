@extends('admin/layout')
@section ('content')

<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-crosshairs-gps menu-icon"></i>
                </span> Voucher Number Generation
              </h3>
              
            </div>
 <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
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
                  <div class="card-body">
                    <h4 class="card-title"></h4>
                     <form class="forms-sample" action ="{{('/createvouchernumber')}}" method = "post" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                  <input type="hidden" name="id" value="" />
                   <div class="row">
                   	<div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Voucher</span>
                        </div>
                        <select  class="form-control"  name="voucherid" id="voucherid" required="required" >
                          <option value="" hidden>Voucher</option>
                          @foreach($lists as $list)
                           <option value="{{$list->id}}" >{{$list->heading}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                </div>
              </div>
               <div class="row result" >
                <div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Cont.</span>
                        </div>
                        <input type="text" class="form-control constants" name="constants" id="constants" value="{{ old('constants') }}" required="required">
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Serial No</span>
                        </div>
                        
                        <input type="text" class="form-control slno" name="slno" id="slno" value="{{ old('slno') }}" required="required">
                      </div>
                    </div>
                </div>
           
          <div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Vo.No</span>
                        </div>
                        
                        <input type="text" class="form-control genvouch" name="genvouch" id="genvouch" value="" readonly>
                      </div>
                    </div>
                </div>
                           </div>
                           <div class="row">
               <div class="col-md-8 col-md-offset-1 mt-2">
            <button type="submit"  class="btn btn-gradient-dark btn-rounded btn-fw">Generate</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw">Cancel</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw" data-toggle="modal" data-target=".bd-find-modal-lg">Find</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw">Delete</button>
            
          </div>
        </div>
                </form>    
                  </div>
                </div>
              </div>

     <!-- /////////////////////// POPUP FOR FIND BUTTON ////////////////////////  --> 
  <div class="modal fade bd-find-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="companyModalLabel">Voucher Number Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                   
                   <table class="table table-bordered findtable" id="findtable">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Generated Voucher Number</th>
     
    </tr>
  </thead>
  <tbody>
    @foreach($vouchs as $vouch)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td>{{$vouch->heading}}</td>
      <td>{{$vouch->genvouch}}</td>
      
    </tr>
   @endforeach
  </tbody>
</table>
                  </div>
                </div>
              </div>      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
              </div>
    </div>
  </div>
</div>
<script src="../../assets/js/jquery-3.6.0.min.js"></script>
 <script type="text/javascript">

 $("#voucherid").change(function(){
  vid=$(this).val();
  csrf = $('#token').val();
$.ajax({
         type: "POST",
         url: "../voucher-number",
         data: {vid: vid,_token:csrf},
         dataType: "html",  
         success: 
              function(result){
               //alert(result);
                $(".result").html(result);
               
              }
          });

 })
 </script>             
@stop