@extends('inventory/layout')
@section ('content')

<div class="page-header">
<h3 class="page-title">
<span class="page-title-icon bg-gradient-info text-white mr-2">
<i class="mdi mdi-chart-bar  menu-icon"></i>
                </span>Cost Calculation</h3>
              
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
                     <form class="forms-sample" action ="{{('/createcostcal')}}" method = "post" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                  <input type="hidden" name="id" value="" />
                  <div class="row" >
                   
                    
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
                  
          </div>
           <div class="row">
               <div class="col-md-8 col-md-offset-1 mt-2">
            <button type="submit"  class="btn btn-gradient-dark btn-rounded btn-fw">Save</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw">Cancel</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw" data-toggle="modal" data-target=".bd-find-modal-lg" disabled>Find</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw">Delete</button>
            
          </div>
        </div>
                </form>    
                  </div>
                </div>
              </div>


<script src="../../assets/js/jquery-3.6.0.min.js"></script>
 <script type="text/javascript">
  $(".pinumber").change(function(){
               pi = $(this).val();
               token = $("#token").val();
              $.ajax({
         type: "POST",
         url: "{{url('loadpallcharges')}}", 
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