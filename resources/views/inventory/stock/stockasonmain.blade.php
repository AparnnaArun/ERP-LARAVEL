@extends('inventory/layout')
@section ('content')
 <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-history   menu-icon"></i>
                </span>  Stock As On Report
              </h3>
              
            </div>

<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                   
                    <input type="hidden" name="_token" class="token" value="{{ csrf_token() }}" id="token"/>
                    <p class="card-description">
                   <!--  Todays stock report with location and batch details  -->
                    </p>
<div class="row">
          <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">Start Date</span>
                        </div>
                       <input  class="form-control datepicker "  name="" id="startdate" >
                        
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
                <div class="col-md-2">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                        
                        </div>
                      <button type="button" class="btn btn-gradient-success btn-xs gos">Go</button>
                        
                      </div>
                    </div>
                </div>
                
         </div>
         <div class="results">
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
           
             $.ajax({
         type: "POST",
         url: "{{url('loadstockason')}}", 
         data: {_token: token,sdate:sdate,edate:edate},
         dataType: "html",  
         success: 
              function(data){
              //alert(data);
                $(".results").html(data);
            

              }
          });

                })
</script>
                 @stop