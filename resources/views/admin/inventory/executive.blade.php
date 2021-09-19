@extends('admin/layout')
@section ('content')
@include('admin.newaccount') 

<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-chart-bar  menu-icon"></i>
                </span>Executive Details
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
                    <form class="forms-sample" action ="{{('/createexecutive')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                   <div class="row">
                   	<div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Executive</span>
                        </div>
                        <select class="form-control executive" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="executive" value="{{ old('name') }}" required >
                            <option value="" hidden>Executive</option>
                        @foreach($emplo as $executive)
                        <option value="{{$executive->id}}" >{{$executive->name}}</option>
                        @endforeach
                        </select>
                      </div>
                    </div>
                </div>
              </div>
          <div class="row result">
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Short Name</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="short_name" value="{{ old('short_name') }}" required>
                        
                      </div>
                    </div>
                </div>
                
                 <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Account</span>
                        </div>
                        
                        <input type="text" class="form-control " aria-label="Amount (to the nearest dollar)" name="account" value="{{ old('account') }}" >
                       
                      </div>
                    </div>
                </div>
            </div>
            <div class="row">
             <div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Commission %</span>
                        </div>
                        
                        <input type="text" class="form-control " aria-label="Amount (to the nearest dollar)" name="commpercent" value="{{ old('commpercent') }}" >
                       
                      </div>
                    </div>
                </div>
                 <div class="col-md-2">
              <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" checked  name="active" value='1'> Active </label>
                            </div>
                          </div>
                          <div class="col-md-3">
           <div class="form-check form-check-info">
                              
                                <label class="form-check-label required"> Is Commissioned?  </label>
                            </div>
                          
                            </div>
                         <div class="col-md-2">
            <div class="form-check form-check-info">
                              
                                <label class="form-check-label"><input type="radio" class="form-check-input commission" name="iscomm"   value="1" > yes </label>
                            </div>
                          </div>
                          <div class="col-md-2">
                          
            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input nocommission" name="iscomm"   value="0" > No </label>
                            </div>
                          </div>
                        </div>
                        <div class="row acccomm" style="display: none;">
                    <div class="col-md-5">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Commission Pay A/C</span>
                        </div>
                        <select class="form-control text-uppercase accname" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="commpay"  >
                           <option value="" hidden>Account</option>
                        @foreach($allaccounts as $all)
                        <option value="{{$all->id}}" >{{$all->printname}}</option>
                        @endforeach
                        </select>
                      </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Executive Commission A/C</span>
                        </div>
                        <select class="form-control text-uppercase accname" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="commexp"  >
                          <option value="" hidden>Account</option>
                        @foreach($allaccounts as $alls)
                        <option value="{{$alls->id}}" >{{$alls->printname}}</option>
                        @endforeach
                        </select>
                      </div>
                    </div>
                </div>
              </div>
                   
              <div class="row mt-1">
               <div class="col-md-8 col-md-offset-1 ">
            <button type="submit" class="btn btn-gradient-dark btn-rounded btn-fw">Save</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw">Cancel</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw" data-toggle="modal" data-target=".bd-find-modal-lg" >Find</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw" >Delete</button>
            
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
        <h5 class="modal-title" id="companyModalLabel">Customer Details</h5>
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
      <th scope="col">Short Name</th>
      <th scope="col">Commission %</th>
     
    </tr>
  </thead>
  <tbody>
     @foreach($datas as $brnd)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td><a href="/admin/executive/{{$brnd->id}}">{{$brnd->name}}</a></td>
      <td><a href="/admin/executive/{{$brnd->id}}">{{$brnd->short_name}}</a></td>
      <td><a href="/admin/executive/{{$brnd->id}}">{{$brnd->commission_percentage}}</a></td>
     
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
<!-- ///////Js Start here//////////////////// -->
<script src="../../assets/js/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
$(".commission").click(function (){
  $(".acccomm").show();

})
$(".nocommission").click(function (){
  $(".acccomm").hide();

})
$(".executive").change(function (){
exce = $(this).val();
token = $("#token").val();
 $.ajax({
         type: "POST",
         url: "{{url('getexedetails')}}", 
         data: {_token: token,exce:exce},
         dataType: "html",  
         success: 
              function(data){
                //alert(data);
                $(".result").html(data);

              }
          });
  
})
</script>
@stop