@extends('accounts/layout')
@section ('content')
 <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-file-chart  menu-icon"></i>
                </span>Commission Details
              </h3>
              
            </div>

<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    
                    <p class="card-description"> 
                    </p>
         <div class="row">
          
          <div class="col-md-4">
          	 <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">Executive</span>
                        </div>
                        <select  class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="" id="executive" >
                        <option value="" hidden >Executive</option>
                        @foreach($exce as $exc)

 <option value="{{$exc->short_name}}" >{{$exc->short_name}}</option>
                        @endforeach
                      </select>
                        
                      </div>
                    </div>
                </div>
               
                
                
                   
         </div>
         <div class="row">
         	<div class="table table-responsive daybook">
         	</div>
         </div>
                    
                  </div>
                </div>
              </div>
             
             <script src="/assets/js/jquery-3.6.0.min.js"></script>
             
<script type="text/javascript">
 $("#executive").change(function(){
  executive = $("#executive").val();
  csrf=$("#token").val();
 
 $.ajax({
         type: "POST",
         url: "{{url('loadcommission')}}", 
         data: {_token: csrf,executive:executive},
         dataType: "html",  
         success: 
              function(data){
              //alert(data);
                $(".daybook").html(data);

              }
          });
   
   });
</script>
                @stop