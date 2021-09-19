@extends('inventory/layout')
@section ('content')
@include('inventory.newvendor')

<style type="text/css">
  .form-check .form-check-label input{
    opacity: 1;
    z-index: 0;
  }
</style>
<div class="page-header">
<h3 class="page-title">
<span class="page-title-icon bg-gradient-info text-white mr-2">
<i class="mdi mdi-chart-bar  menu-icon"></i>
                </span> Additional Purchase Costs Details</h3>
              
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
                    <p>Values can be edited if it's not settled</p>
                     <form class="forms-sample" action ="{{('/createpicost')}}" method = "post" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                  <input type="hidden" name="id" value="" />
                  <div class="row" >
                   
                    <div class="col-md-3">
                   
                </div>
                    <div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">PI#</span>
                        </div>
                        <select class="form-control pinumber" placeholder="" name="pi_no" required="" >
                          <option value="" hidden>PI Number</option>
                     @foreach($pi as $cust)
                        <option value="{{$cust->p_invoice,old('vendor')}}" >{{$cust->p_invoice}}</option>
                        @endforeach
                        </select>
                          
                      </div>
                    </div>
                </div>
              </div>
              <div id="loadcharge">
                  
        
           <div class="row">
               <div class="col-md-8 col-md-offset-1 mt-2">
            <button type="submit"  class="btn btn-gradient-dark btn-rounded btn-fw">Save</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw">Cancel</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw" data-toggle="modal" data-target=".bd-find-modal-lg" disabled>Find</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw">Delete</button>
            
          </div>
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
        <h5 class="modal-title" id="companyModalLabel">Brand Details</h5>
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
      <th scope="col">brand</th>
      <th scope="col">Description</th>
     <th scope="col">Status</th>
   </tr>
  </thead>
 <tbody>
    
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

 <script type="text/javascript">
  $(".pinumber").change(function(){
               pi = $(this).val();
               token = $("#token").val();
              $.ajax({
         type: "POST",
         url: "{{url('loadpicharge')}}", 
         data: {_token: token,pi:pi},
         dataType: "html",  
         success: 
              function(data){
              //alert(data);
                $("#loadcharge").html(data);

              }
          });

                })

       </script>             
@stop