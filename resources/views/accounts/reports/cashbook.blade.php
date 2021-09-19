@extends('accounts/layout')
@section ('content')
 <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-file-chart menu-icon"></i>
                </span>{{$heading}}
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
                       <input  class="form-control datepicker" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="" id="startdate" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">End Date</span>
                        </div>
                       <input  class="form-control datepicker" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="" id="enddate" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white add-on ">Account</span>
                     
                       <select class="form-control mySelect2 "  name="" id="account" >
                          <option value="" hidden>Account</option>
                          @foreach($acc as $row)
                        <option value="{{$row->id}}" >{{$row->printname}}</option>
                        @endforeach
                    
                        </select>
                           </div>
                      </div>
                    </div>
                </div>
                
                   
         </div>
         <div class="result">
        
         </div>
                   
                  </div>
                </div>
              </div>
                         <script src="/assets/js/jquery-3.6.0.min.js"></script>
             
<script type="text/javascript">
  $(function(){
                $("#account").change(function(){
               account = $("#account").val();
               startdate = $("#startdate").val();
               enddate = $("#enddate").val();
               token = $("#token").val();
               book ='Cash Book';

             $.ajax({
         type: "POST",
         url: "{{url('getallbook')}}", 
         data: {enddate:enddate,_token: token,startdate:startdate,account:account,book:book},
         dataType: "html",  
         success: 
              function(data){
              //alert(data);
                $(".result").html(data);
            

              }
          });
   })
                })
</script> 
  
                @stop