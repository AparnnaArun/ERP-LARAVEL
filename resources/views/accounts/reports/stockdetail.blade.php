@extends('accounts/layout')
@section ('content')
 <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-file-chart  menu-icon"></i>
                </span>Stock Details
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
                          <span class="input-group-text bg-gradient-info text-white  ">Choose Date</span>
                        </div>
                        <input  class="form-control datepicker"  name="" id="startdate" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
          
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                         
                        </div>
                       <button class="btn btn-gradient-success btn-xs addtogrid">Go</button>
                        
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
 $(".addtogrid").click(function(){
  startdate = $("#startdate").val();
  csrf=$("#token").val();
$.ajax({
         type: "POST",
         url: "{{url('loadstock')}}", 
         data: {_token: csrf,startdate:startdate},
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