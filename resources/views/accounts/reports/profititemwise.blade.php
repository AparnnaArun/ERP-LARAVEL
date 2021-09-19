@extends('accounts/layout')
@section ('content')
<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-file-chart"></i>
                </span>Profit Analysis ItemWise
              
            </div> 

<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
           
                    <p class="card-description">Material Issue & Sales Invoices are given separately 
                    </p>
                    <input type="hidden" name="_token" class="token" value="{{ csrf_token() }}" id="token"/>
         <div class="row">
          <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">Start Date</span>
                        </div>
                       <input  class="form-control datepicker"  name="" id="startdate" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">End Date</span>
                        </div>
                       <input  class="form-control datepicker"  name="" id="enddate" >
                        
                      </div>
                    </div>
                </div>
          
                <div class="col-md-1">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                        
                        </div>
                      <button type="button" class="btn btn-gradient-success btn-xs gos">Go</button>
                        
                      </div>
                    </div>
                </div>
                
         </div>
         <div class="row">
          <div class="col-md-12 result">
            
          </div>
        </div>

              </div>
                  </div>
                </div>

             
             <script src="/assets/js/jquery-3.6.0.min.js"></script>
             
<script type="text/javascript">
                $(".gos").click(function(){
              
               sdate = $("#startdate").val();
               edate = $("#enddate").val();
               token = $("#token").val();
               //alert(sdate);
             $.ajax({
         type: "POST",
         url: "{{url('getprofitmovement')}}", 
         data: {_token: token,sdate:sdate,edate:edate},
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