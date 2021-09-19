@extends('accounts/layout')
@section ('content')
<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-file-chart"></i>
                </span>Product Sales History
              
            </div> 

<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
           
                    <p class="card-description"> 
                    </p>
                    <input type="hidden" name="_token" class="token" value="{{ csrf_token() }}" id="token"/>
         <div class="row">
          <div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">Start Date</span>
                        </div>
                       <input  class="form-control datepicker"  name="" id="startdate" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">End Date</span>
                        </div>
                       <input  class="form-control datepicker"  name="" id="enddate" >
                        
                      </div>
                    </div>
                </div>
          <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  add-on">Item</span>
                    
                       <select  class="form-control mySelect2"  name="" id="item" >
                        <option value="" hidden >Item</option>
                        @foreach($stock as $cust)

 <option value="{{$cust->id}}" >{{$cust->item}}</option>
                        @endforeach
                      </select>
                          </div>
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
               item = $("#item").val();
               sdate = $("#startdate").val();
               edate = $("#enddate").val();
               token = $("#token").val();
               //alert(sdate);
             $.ajax({
         type: "POST",
         url: "{{url('gethistorymovement')}}", 
         data: {item:item,_token: token,sdate:sdate,edate:edate},
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