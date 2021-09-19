@extends('inventory/layout')
@section ('content')
 <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-file-chart  menu-icon"></i>
                </span>Delivery Note Report
              </h3>
              
            </div>

<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    
                    <p class="card-description"> 
                    </p>
         <div class="row">
          <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
          <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">Start Date</span>
                        </div>
                       <input  class="form-control datepicker"  id="startdate" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">End Date</span>
                        </div>
                       <input  class="form-control datepicker"  id="enddate" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">Executive</span>
                        </div>
                        
                       <select  class="form-control "  name="" id="executive" >
                        <option hidden >Executive</option>
                        @foreach($execus as $exe)
                       <option value="{{$exe->short_name}}">{{$exe->short_name}}</option>
                        @endforeach
                       </select>
                       
                      </div>
                    </div>
                </div>
                
                   
         </div>
         <div class="testt">
         
              </div>
                  </div>
                </div>
              </div>
             
             <script src="/assets/js/jquery-3.6.0.min.js"></script>
             
<script type="text/javascript">
 $("#executive").change(function(){
startdate = $("#startdate").val();
enddate = $("#enddate").val();
executive =$(this).val();
token =$("#token").val();
//alert(executive);
        $.ajax({
         type: "POST",
         url: "{{url('loaddoreport')}}", 
         data: {_token: token,startdate:startdate,enddate:enddate,executive:executive},
         dataType: "html",  
         success: 
              function(data){
                //alert(data);
             $(".testt").html(data);
               }
          });

                });   
</script>
                @stop